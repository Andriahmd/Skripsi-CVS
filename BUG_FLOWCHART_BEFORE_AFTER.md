# 🔧 PERBAIKAN BUG - VISUAL FLOWCHART

## BUG #1: PEMERIKSAAN KOSONG

### BEFORE (Buggy Behavior)
```
┌─────────────────────────────────────────────────────────────────┐
│ User Start Screening                                            │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ createPemeriksaan()                                             │
│ - Check: hasil_diagnosa IS NULL                               │
│ - FOUND: ID=100                                               │
│ - RETURN: ID=100 (NO CHECK IF SCREENING PASSED!)              │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Answer Partial Screening (3/5 inklusi)                   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ simpanScreening()                                              │
│ - updateOrCreate() inklusi_eksklusi                           │
│ - complete = false → return "sementara"                        │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Close Browser / Click Menu                               │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Come Back → createPemeriksaan()                          │
│ - Check: hasil_diagnosa IS NULL                               │
│ - FOUND: ID=100 AGAIN ❌ (REUSE TANPA CEK!)                   │
│ - RETURN: ID=100                                              │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Complete Screening (5/5 inklusi + 7/7 eksklusi)         │
│ - simpanScreening(): memenuhi_inklusi=TRUE, ada_eksklusi=FALSE│
│ - LOLOS! Return: redirect to submit gejala                    │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Submit Jawaban Gejala → submitTotal()                    │
│ - Calculate CF dari ID=100                                    │
│ - Set: hasil_diagnosa, persentase_cf                          │
│ ❌ PROBLEM: CF Calculation tidak akurat / hasil kosong        │
│    Karena data lama masih ada atau inkonsisten               │
└─────────────────────────────────────────────────────────────────┘

DATABASE STATE (BUGGY):
─────────────────────────────────────────
Pemeriksaan: 
  id=100, persentase_cf=0, hasil_diagnosa=NULL ← stale data

Jawaban (dari screening 3/5):
  - Data gejala dari iterasi lama

InklusiEksklusi:
  - Status dari iterasi lama (incomplete)
```

### AFTER (Fixed Behavior)
```
┌─────────────────────────────────────────────────────────────────┐
│ User Start Screening                                            │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ createPemeriksaan()                                             │
│ - Load: Pemeriksaan dengan inklusiEksklusi relation           │
│ - Check: hasil_diagnosa IS NULL                               │
│ - FOUND: ID=100                                               │
│ - ✅ CHECK: lolosScreening() = false                           │
│ - ACTION: Delete jawaban, inklusi_eksklusi, pemeriksaan       │
│ - CREATE: New Pemeriksaan ID=101 (FRESH STATE)                │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Answer Partial Screening (3/5 inklusi) with ID=101       │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ simpanScreening()                                              │
│ - Find or Create inklusi_eksklusi (ID=101)                    │
│ - complete = false → return "sementara"                        │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Close Browser / Click Menu                               │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Come Back → createPemeriksaan()                          │
│ - Check: hasil_diagnosa IS NULL                               │
│ - FOUND: ID=101                                               │
│ - ✅ CHECK: lolosScreening() = false (incomplete)              │
│ - ACTION: Delete jawaban, inklusi_eksklusi, pemeriksaan       │
│ - CREATE: New Pemeriksaan ID=102 (FRESH START)                │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Complete Screening (5/5 inklusi + 7/7 eksklusi) ID=102  │
│ - simpanScreening(): memenuhi_inklusi=TRUE, ada_eksklusi=FALSE│
│ - LOLOS! Commit transaction → Return redirect                 │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ User Submit Jawaban Gejala → submitTotal()                    │
│ - Calculate CF dari ID=102 (FRESH DATA)                       │
│ - Set: hasil_diagnosa, persentase_cf ✅ AKURAT                │
└─────────────────────────────────────────────────────────────────┘

DATABASE STATE (FIXED):
─────────────────────────────────────────
Pemeriksaan: 
  id=100 (DELETED)
  id=101 (DELETED)
  id=102 (ACTIVE) ✅ Fresh state, semua data konsisten

Jawaban (ID=102):
  - Data gejala baru, clean state

InklusiEksklusi (ID=102):
  - Status lolos screening
```

---

## BUG #2: INKLUSI/EKSKLUSI TIDAK TER-UPDATE

### BEFORE (Buggy Behavior)
```
ATTEMPT 1: Screening Gagal
┌────────────────────────────────────┐
│ User Answer: 3 inklusi "Ya"        │
│ + 1 eksklusi "Ya"                  │
│ → GAGAL screening                  │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ simpanScreening()                  │
│ isComplete=true, lolos=false       │
│ → updateOrCreate() set to GAGAL    │
│ → DELETE Pemeriksaan ID=100        │
│ ⚠️  inklusi_eksklusi TIDAK HAPUS   │
└────────────────────────────────────┘

DATABASE STATE (Inconsistent):
- Pemeriksaan: ID=100 DELETED
- InklusiEksklusi: STILL EXISTS (orphan) ← BUG!
  id_pemeriksaan=100, memenuhi_inklusi=false, ada_eksklusi=true

ATTEMPT 2: Retry dengan kondisi baru (5 inklusi, 0 eksklusi - LOLOS)
┌────────────────────────────────────┐
│ createPemeriksaan()                │
│ - Check: hasil_diagnosa IS NULL    │
│ - NO old pemeriksaan (sudah delete)│
│ - CREATE: New ID=101               │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ User Answer: 5 inklusi "Ya"        │
│ + 0 eksklusi "Ya"                  │
│ → SHOULD LOLOS                     │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ simpanScreening() ID=101           │
│ updateOrCreate() set to LOLOS      │
│ BUT: Old record (id_pemeriksaan100)│
│      still exists!                 │
│ → Inconsistent state               │
│                                    │
│ ⚠️  RACE CONDITION:                 │
│ If DB query uses wrong ID:         │
│ Might read old lolosScreening()=FLS│
│ instead of new lolosScreening()=TRUE
└────────────────────────────────────┘

RESULT: ❌ Kondisi lama atau baru tidak konsisten
```

### AFTER (Fixed Behavior)
```
ATTEMPT 1: Screening Gagal
┌────────────────────────────────────┐
│ User Answer: 3 inklusi "Ya"        │
│ + 1 eksklusi "Ya"                  │
│ → GAGAL screening                  │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ simpanScreening() WRAPPED IN TX    │
│ isComplete=true, lolos=false       │
│                                    │
│ BEGIN TRANSACTION                  │
│ ✅ DELETE Jawaban (ID=100)         │
│ ✅ DELETE InklusiEksklusi (ID=100) │
│ ✅ DELETE Pemeriksaan (ID=100)     │
│ COMMIT                             │
│ → Atomic & complete cleanup        │
└────────────────────────────────────┘

DATABASE STATE (Clean):
- Pemeriksaan: DELETED
- InklusiEksklusi: DELETED ✅
- Jawaban: DELETED ✅

ATTEMPT 2: Retry (5 inklusi, 0 eksklusi - LOLOS)
┌────────────────────────────────────┐
│ createPemeriksaan()                │
│ - Check: hasil_diagnosa IS NULL    │
│ - NO old pemeriksaan               │
│ - CREATE: New ID=101 (FRESH)       │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ User Answer: 5 inklusi "Ya"        │
│ + 0 eksklusi "Ya"                  │
│ → LOLOS!                           │
└────────────────────────────────────┘
         ↓
┌────────────────────────────────────┐
│ simpanScreening() ID=101           │
│ Dalam Transaction:                 │
│ 1. Find inklusi_eksklusi (ID=101)  │
│    NOT FOUND                       │
│ 2. CREATE new with:                │
│    memenuhi_inklusi=true           │
│    ada_eksklusi=false              │
│ 3. Validate lolos=true             │
│ 4. COMMIT transaction              │
│ → ✅ Atomic & consistent           │
└────────────────────────────────────┘

DATABASE STATE (Consistent):
- Pemeriksaan: ID=101 (ACTIVE)
- InklusiEksklusi: ID=101 (LOLOS) ✅
- Jawaban: ID=101 (CLEAN) ✅

RESULT: ✅ Semua ter-update dengan benar, tidak ada orphan
```

---

## COMPARISON: BEFORE vs AFTER

### Data Flow Visualization

#### BEFORE (Problematic)
```
User Action                    Database                   Result
─────────────────────────────────────────────────────────────────
Start Screening      →  Create Pemeriksaan#100
                         
Partial Answer       →  Update InklusiEksklusi#100
Close & Come Back         (status=incomplete)

                     ↓    
Complete Screening   →  Update InklusiEksklusi#100
                         (status=lolos)  
                         ⚠️ Reuse ID#100!
                         ⚠️ Old jawaban still there
                         
Submit Gejala        →  Calculate CF
                         ❌ Result: Empty/Kosong/Stale

───────────────────────────────────────────────────────────────
Second Attempt       →  Check hasil_diagnosa=NULL
                         FOUND ID#100 still
                         ⚠️ Delete only Pemeriksaan
                         ⚠️ InklusiEksklusi orphan remains
                         
                         OR might find old record
                         ❌ Result: Kondisi lama tidak ter-update
```

#### AFTER (Fixed)
```
User Action                    Database                   Result
─────────────────────────────────────────────────────────────────
Start Screening      →  Create Pemeriksaan#100
                         
Partial Answer       →  Update InklusiEksklusi#100
                         (status=incomplete)
Close & Come Back    
                     ↓ createPemeriksaan() checks:
                         lolosScreening() = false
                         → DELETE all relations
                         → Fresh start
                         
Complete Screening   →  Create NEW Pemeriksaan#101
                         Create NEW InklusiEksklusi#101
                         (status=lolos)
                         
Submit Gejala        →  Calculate CF from ID#101
                         ✅ Result: Akurat & Clean

───────────────────────────────────────────────────────────────
Second Attempt (Gagal) →  Pemeriksaan#102
                         DELETE in transaction:
                         - Jawaban
                         - InklusiEksklusi  ✅ Explicit
                         - Pemeriksaan
                         
Second Attempt (Lolos) →  Create Pemeriksaan#103
                         Create InklusiEksklusi#103
                         (status=lolos)
                         ✅ Result: Always Updated & Consistent
```

---

## KEY IMPROVEMENTS

| Metric | BEFORE | AFTER |
|--------|--------|-------|
| **Transaction Scope** | Partial | ✅ Full atomic |
| **ID Reuse** | Problematic | ✅ Fresh each time |
| **Orphan Records** | Possible | ✅ Prevented |
| **Update Consistency** | ambiguous `updateOrCreate()` | ✅ Explicit `update()` / `create()` |
| **Screening Validation** | No | ✅ Yes (lolosScreening check) |
| **Delete Completeness** | Only Pemeriksaan | ✅ All relations |
| **Race Condition** | Vulnerable | ✅ Protected by TX |

---

## SQL Pattern Comparison

### BEFORE: updateOrCreate (Ambiguous)
```sql
-- Might UPDATE or CREATE, unclear state
UPDATE inklusi_eksklusi 
SET memenuhi_inklusi = true, ada_eksklusi = false 
WHERE id_pemeriksaan = 100;

-- If no row updated, then INSERT
INSERT INTO inklusi_eksklusi 
(id_pemeriksaan, memenuhi_inklusi, ada_eksklusi) 
VALUES (100, true, false);

-- Problem: Race condition if both happen
```

### AFTER: Explicit Logic (Clear)
```sql
-- Check if exists
SELECT * FROM inklusi_eksklusi WHERE id_pemeriksaan = 101;

-- If exists → UPDATE with new values
UPDATE inklusi_eksklusi 
SET memenuhi_inklusi = true, ada_eksklusi = false, updated_at = NOW()
WHERE id_pemeriksaan = 101;

-- If not exists → INSERT new
INSERT INTO inklusi_eksklusi 
(id_pemeriksaan, memenuhi_inklusi, ada_eksklusi) 
VALUES (101, true, false);

-- ✅ Clear intent, no race condition
```

### BEFORE: Incomplete Delete
```sql
DELETE FROM pemeriksaan WHERE id = 100;
-- Jawaban cascade delete (maybe)
-- InklusiEksklusi NOT DELETED ❌ (foreign key points to pemeriksaan)
```

### AFTER: Atomic Complete Delete
```sql
BEGIN TRANSACTION;
  DELETE FROM jawaban WHERE id_pemeriksaan = 100;
  DELETE FROM inklusi_eksklusi WHERE id_pemeriksaan = 100;
  DELETE FROM pemeriksaan WHERE id = 100;
COMMIT;
-- ✅ All cleaned, atomic operation
```

---

