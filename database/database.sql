-- Create a database, 1st check the database, if not exists then create a database
IF NOT EXISTS (
    SELECT name 
    FROM master.dbo.sysdatabases 
    WHERE name = 'wctf'
)
BEGIN
    CREATE DATABASE wctf;
END
GO

-- use this database for the next coming command | execution
USE wctf;
GO

-- Now create a admin table for admin authentication
CREATE TABLE Admin (
    id INT PRIMARY KEY IDENTITY(1,1),
    name NVARCHAR(50),
    email NVARCHAR(100),
    password NVARCHAR(255),
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO

-- Now create a patients table for store patient details
CREATE TABLE Patients (
    id INT PRIMARY KEY IDENTITY(1,1),
    fname NVARCHAR(50),
    sname NVARCHAR(50),
    dob DATE,
    total INT,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO

-- Now create a questions table for store questions
CREATE TABLE Questions (
    id INT PRIMARY KEY IDENTITY(1,1),
    question NVARCHAR(255),
    range_min INT,
    range_max INT,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO

-- Now create a responses table for store patient responses
CREATE TABLE Responses (
    id INT PRIMARY KEY IDENTITY(1,1),
    patient_id INT,
    question_id INT,
    response INT,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (patient_id) REFERENCES Patients(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (question_id) REFERENCES Questions(id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO

---------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------   Procedures   ---------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------------

-- create a patient and details
CREATE PROCEDURE sp_createPatientAndResponses (@fname NVARCHAR(50), @sname NVARCHAR(50), @dob DATE, @total INT, @responses NVARCHAR(MAX)) AS
BEGIN
    DECLARE @pid INT;

    INSERT INTO Patients (fname, sname, dob, total) VALUES (@fname, @sname, @dob, @total);
    SET @pid = SCOPE_IDENTITY();

    DECLARE @json NVARCHAR(MAX) = @responses;
    INSERT INTO Responses (patient_id, question_id, response)
    SELECT @pid, question_id, response
    FROM OPENJSON(@json)
    WITH (
        question_id INT '$.question_id',
        response INT '$.response'
    );
END;
GO

-- get all patients
CREATE PROCEDURE sp_getPatients 
AS
BEGIN
    SELECT p.id, p.fname, p.sname, p.dob, p.total, p.created_at, p.updated_at
    FROM Patients p;
END;
GO

-- get a patient by patient id
CREATE PROCEDURE sp_getPatientById (@id INT) AS
BEGIN
    SELECT p.id, p.fname, p.sname, p.dob, p.total, p.created_at, p.updated_at,
           r.question_id, r.response, r.id as response_id
    FROM Patients p
    LEFT JOIN Responses r ON p.id = r.patient_id
    WHERE p.id = @id;
END;
GO

-- update a patient details
CREATE PROCEDURE sp_updatePatientAndResponses ( @id INT, @fname NVARCHAR(50), @sname NVARCHAR(50), @dob DATE, @total INT, @responses NVARCHAR(MAX))
AS
BEGIN
  BEGIN TRY
    BEGIN TRANSACTION;

    UPDATE Patients SET fname = @fname, sname = @sname, dob = @dob, total = @total, updated_at = GETDATE() WHERE id = @id;

    DECLARE @json NVARCHAR(MAX) = @responses;

    UPDATE R SET R.response = J.response FROM Responses R CROSS APPLY OPENJSON(@json) WITH ( response_id INT '$.response_id', response INT '$.response') J WHERE R.id = J.response_id;

    COMMIT TRANSACTION;

  END TRY
  BEGIN CATCH
    IF @@TRANCOUNT > 0
      ROLLBACK TRANSACTION;
    THROW;
  END CATCH;
END;
GO


-- delete a patient details
CREATE PROCEDURE sp_deletePatient (@id INT) AS
BEGIN
    DELETE FROM Patients WHERE id = @id;
END;
GO 

-- get all question records
CREATE PROCEDURE sp_GetQuestions
AS
BEGIN
    SELECT id, Question, range_min, range_max FROM Questions;
END;
GO

-- insert a question records
CREATE PROCEDURE sp_InsertQuestions
AS
BEGIN
    INSERT INTO Questions (Question, range_min, range_max, created_at, updated_at)
    VALUES
        ('How much relief have pain treatments or medications <b><u>FROM THIS CLINIC provided</b></u>?', 0, 100, GETDATE(), GETDATE()),
        ('Please rate your pain based on the number that best describes your pain at it''s <b><u>WORST</b></u> in the past week.', 0, 10, GETDATE(), GETDATE()),
        ('Please rate your pain based on the number that best describes your pain at it''s <b><u>LEAST</b></u> in the past week.', 0, 10, GETDATE(), GETDATE()),
        ('Please rate your pain based on the number that best describes your pain on the <b><u>Average</b></u>.', 0, 10, GETDATE(), GETDATE()),
        ('Please rate your pain based on the number that best describes your pain that tells how much pain you have <b><u>RIGHT NOW</b></u>.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: General Activity.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Mood.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Walking ability.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Normal work (includes work both outside the home and housework).', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Relationships with other people.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Sleep.', 0, 10, GETDATE(), GETDATE()),
        ('Based on the number that best describes how during the past week pain has <b><u>INTERFERED</b></u> with your: Enjoyment of life.', 0, 10, GETDATE(), GETDATE());
END;
GO

-- execute a insert question procedure for default question records
EXEC sp_InsertQuestions;
GO

-- insert a question records
CREATE PROCEDURE sp_InsertDefaultAdmin
AS
BEGIN
    INSERT INTO Admin (name, email, password, created_at, updated_at)
    VALUES
        ('admin','admin@mailinator.com','Admin@123',GETDATE(), GETDATE());
END;
GO

-- execute a insert default admin record
EXEC sp_InsertDefaultAdmin;
GO

-- check the admin login
CREATE PROCEDURE sp_CheckAdminLogin
    @email NVARCHAR(50),
    @password NVARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @Result INT;

    SELECT @Result = COUNT(*)
    FROM Admin 
    WHERE email = @email 
    AND password = @password;

    IF @Result > 0
        SELECT 1 AS Result;
    ELSE
        SELECT 0 AS Result;
END;
GO