Todo:
- Implementation of Guidance Role
- Some UI Upgrades and Implementation


## Revisions
### Background: 
Kaya nagiging SA/student assistant ang isang student, dahil sa scholarship niya. Kapag natanggal yung scholarship, hindi na siya magiging part SA.

### Added Module/Features: 
Check  scholarship status BEFORE assigning tasks to SAs 

### New User: Guidance Office 
- Dashboard 
- Probation Page: Shows lists SAs with 0.0 at the end of school year
- Revoke Scholarship page: Shows lists SAs with 0.0 for TWO CONSECUTIVE school YEARS
- Revoke Scholarship page: Enter his/her verdict on SA's scholarship status; "probation", "remove scholarship"

### New features on SA Manager Side:
- Dashboard
- Can Add Major Offense: name, type of offense, offense status, duration(can add only if offense status is "probation")
- Probation Page: Track students with probation for major offenses
- Revoke Scholarship Page: Enter his/her verdict on SA's scholarship status; "probation", "remove scholarship"

### New features on SA:
- Account is deactivated once guidance/sa manager revoked SA's scholarship
- Account cannot received tasks if under probation period for MAJOR OFFENSE
- Account can still receive tasks and be opened when under probation for 0.0 GRADE

### Database: 
- Add new tables for grades and major offenses...(?)