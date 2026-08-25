[schema1 (1).sql](https://github.com/user-attachments/files/31409024/schema1.1.sql)
<img width="1920" height="1046" alt="pgAdmin 4 8_25_2026 11_43_14 AM" src="https://github.com/user-attachments/assets/a28cc204-d93b-4639-9558-2f42d53843a2" />
<img width="1920" height="1046" alt="pgAdmin 4 8_25_2026 11_43_36 AM" src="https://github.com/user-attachments/assets/513f99ac-edca-4581-9200-ee12aef020cf" />
<img width="1920" height="1046" alt="pgAdmin 4 8_25_2026 11_42_27 AM" src="https://github.com/user-attachments/assets/d82e167e-750c-46c5-b62b-c587ab46a9d4" />

DROP TABLE patients;		
DROP TABLE doctors;
DROP TABLE appointments;


-- 1. Patients Table
CREATE TABLE patients (
    p_id INT GENERATED ALWAYS AS IDENTITY (START WITH 1001) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender VARCHAR(10) CHECK (gender IN ('Male', 'Female', 'Other')),
    date_of_birth DATE NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE
);



ALTER TABLE patients  
ADD COLUMN address VARCHAR(100);




CREATE TABLE doctors (
    d_id INT GENERATED ALWAYS AS IDENTITY (START WITH 5001) PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);


CREATE TABLE appointments (
    appointment_id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    p_id INT NOT NULL,
    d_id INT NOT NULL,
    appointment_date TIMESTAMP NOT NULL,
    CONSTRAINT fk_patient FOREIGN KEY (p_id) REFERENCES patients(p_id) ON DELETE CASCADE,
    CONSTRAINT fk_doctor FOREIGN KEY (d_id) REFERENCES doctors(d_id) ON DELETE CASCADE
);





INSERT INTO patients (first_name, last_name, gender, date_of_birth, phone, email) VALUES
('Rahul', 'Sharma', 'Male', '1995-04-12', '9876543210', 'rahul.s@example.com'),
('Priya', 'Verma', 'Female', '1998-08-22', '9123456789', 'priya.v@example.com'),
('Amit', 'Singh', 'Male', '1988-11-05', '9988776655', 'amit.s@example.com');


INSERT INTO doctors (first_name, last_name, specialization, phone, email) VALUES
('Sanjay', 'Gupta', 'Cardiology', '9000011111', 'dr.sanjay@hospital.com'),
('Ananya', 'Roy', 'Dermatology', '9000022222', 'dr.ananya@hospital.com'),
('Vikram', 'Mehta', 'Orthopedics', '9000033333', 'dr.vikram@hospital.com');


INSERT INTO appointments (p_id, d_id, appointment_date) VALUES
(1001, 5001, '2026-08-26 10:00:00'),
(1002, 5002, '2026-08-26 11:30:00'),
(1003, 5003, '2026-08-27 14:00:00');
select * from patients;
select * from doctors;
select * from appointments;


SELECT 
    a.appointment_id,
    p.first_name || ' ' || p.last_name AS patient_name,
    'Dr. ' || d.first_name || ' ' || d.last_name AS doctor_name,
    d.specialization,
    a.appointment_date
FROM appointments a
JOIN patients p ON a.p_id = p.p_id
JOIN doctors d ON a.d_id = d.d_id
ORDER BY a.appointment_id DESC;




ALTER TABLE appointments 
ADD COLUMN patient_name VARCHAR(100);

UPDATE appointments a
SET patient_name = p.first_name || ' ' || p.last_name
FROM patients p
WHERE a.p_id = p.p_id;


ALTER TABLE appointments 
ADD COLUMN doctor_name VARCHAR(100);

UPDATE appointments a
SET doctor_name = 'Dr. ' || d.first_name || ' ' || d.last_name
FROM doctors d
WHERE a.d_id = d.d_id;



CREATE OR REPLACE FUNCTION set_names()
RETURNS TRIGGER AS $$
BEGIN
    SELECT first_name || ' ' || last_name 
    INTO NEW.patient_name
    FROM patients WHERE p_id = NEW.p_id;

    SELECT 'Dr. ' || first_name || ' ' || last_name 
    INTO NEW.doctor_name
    FROM doctors WHERE d_id = NEW.d_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


ALTER TABLE appointments RENAME TO appointments_data;


CREATE VIEW appointments AS
SELECT 
    appointment_id,
    p_id,
    patient_name,
    d_id,
    doctor_name,
    appointment_date
FROM appointments_data
ORDER BY appointment_id DESC;

SELECT table_schema, table_name, table_type 
FROM information_schema.tables 
WHERE table_name = 'appointments';
