
CREATE TABLE IF NOT EXISTS PERSONAS (
dni_persona char(9) PRIMARY KEY,
nombre VARCHAR(50) NOT NULL,
apellidos VARCHAR(50) NOT NULL,
fecha_nacimiento date NOT NULL,
direccion VARCHAR(50) NOT NULL,
localidad VARCHAR(50) NOT NULL,
provincia VARCHAR(50) NOT NULL,
telefono char(9) NOT NULL,
email VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS MEDICACION(
id_medicamento INT AUTO_INCREMENT PRIMARY KEY,
nombre_comercial VARCHAR(50) NOT NULL,
principio_activo VARCHAR(50) NOT NULL,
concentracion VARCHAR(50) NOT NULL,
via_administracion VARCHAR(50) NOT NULL,
formato VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS TRABAJADORES(
id_trabajador INT AUTO_INCREMENT PRIMARY KEY,
rol VARCHAR(50),
usuario VARCHAR(50),
pass VARCHAR(50),
dni_trabajador char(9) UNIQUE,
CONSTRAINT TRA_DNI_FK FOREIGN KEY (dni_trabajador) REFERENCES PERSONAS (dni_persona) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS DEPENDIENTES (
id_dependiente INT AUTO_INCREMENT PRIMARY KEY,
nivel_dependencia VARCHAR(10),
num_habitacion INT UNIQUE,
familiar_referencia VARCHAR(50),
nombre_fam_referencia VARCHAR(50),
telefono_fam_referencia VARCHAR(50),
dni_dependiente char(9) NOT NULL,
CONSTRAINT DEP_DNI_FK FOREIGN KEY (dni_dependiente) REFERENCES PERSONAS (dni_persona) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS CITAS(
id_cita INT AUTO_INCREMENT PRIMARY KEY,
fecha DATE NOT NULL,
hora TIME NOT NULL,
centro VARCHAR(50) NOT NULL,
localidad VARCHAR(50) NOT NULL,
provincia VARCHAR(50) NOT NULL,
direccion VARCHAR(50)NOT NULL,
planta VARCHAR(50),
especialidad VARCHAR(50) NOT NULL,
id_dependiente INT,
CONSTRAINT CIT_IDD_FK FOREIGN KEY (id_dependiente) REFERENCES DEPENDIENTES (id_dependiente) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS CONSULTAS(
id_consulta INT AUTO_INCREMENT PRIMARY KEY,
nombre_medico VARCHAR(50),
motivo_visita TEXT NOT NULL,
descripcion TEXT NOT NULL,
diagnostico VARCHAR(50),
id_cita INT,
CONSTRAINT CON_TRA_FK FOREIGN KEY (id_cita) REFERENCES CITAS (id_cita) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS TRATAMIENTOS(
id_tratamiento INT AUTO_INCREMENT PRIMARY KEY,
sintoma TEXT NOT NULL,
pauta_medicacion VARCHAR(100) NOT NULL,
pauta_reducida VARCHAR(20),
tipo VARCHAR(20) NOT NULL,
fecha_inicio DATE NOT NULL,
fecha_fin DATE NOT NULL,
id_consulta INT,
id_medicamento INT,
CONSTRAINT TRA_IDC_FK FOREIGN KEY (id_consulta) REFERENCES CONSULTAS (id_consulta) ON DELETE SET NULL,
CONSTRAINT TRA_MED_FK FOREIGN KEY (id_medicamento) REFERENCES MEDICACION (id_medicamento) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS EVALUACIONES(
id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
fecha date NOT NULL,
num_sesion INT NOT NULL,
descripcion TEXT NOT NULL,
objetivo TEXT NOT NULL,
prox_cita DATE NOT NULL,
id_psicologo INT,
id_dependiente INT,
CONSTRAINT EVA_IDP_FK FOREIGN KEY (id_psicologo) REFERENCES TRABAJADORES (id_trabajador) ON DELETE SET NULL,
CONSTRAINT EVA_IDD_FK FOREIGN KEY (id_dependiente) REFERENCES DEPENDIENTES (id_dependiente) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS PAUTAS(
id_pauta INT AUTO_INCREMENT PRIMARY KEY,
fecha DATE NOT NULL,
num_sesion INT NOT NULL,
descripcion TEXT NOT NULL,
objetivo TEXT NOT NULL,
prox_cita DATE NOT NULL,
id_terapeuta INT,
id_dependiente INT,
CONSTRAINT PAU_IDT_FK FOREIGN KEY (id_terapeuta) REFERENCES TRABAJADORES (id_trabajador) ON DELETE SET NULL,
CONSTRAINT PAU_IDD_FK FOREIGN KEY (id_dependiente) REFERENCES DEPENDIENTES (id_dependiente) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS INCIDENCIAS(
id_incidencia INT AUTO_INCREMENT PRIMARY KEY,
fecha DATE NOT NULL,
descripcion TEXT NOT NULL,
id_trabajador INT,
id_dependiente INT,
CONSTRAINT INC_IDT_FK FOREIGN KEY (id_trabajador) REFERENCES TRABAJADORES (id_trabajador) ON DELETE SET NULL,
CONSTRAINT INC_IDD_FK FOREIGN KEY (id_dependiente) REFERENCES DEPENDIENTES (id_dependiente)  ON DELETE SET NULL
);

INSERT INTO personas (dni_persona, nombre, apellidos, fecha_nacimiento, direccion, localidad, provincia, telefono, email) VALUES
('12345678A', 'Juan', 'Pérez Gómez', '1990-01-01', 'Calle Mayor, 1', 'Madrid', 'Madrid', '666777888', 'juanperez@email.com'),
('23456789B', 'María', 'López García', '1991-02-02', 'Calle Menor, 2', 'Barcelona', 'Barcelona', '999888777', 'marialopez@email.com'),
('34567890C', 'Pedro', 'García Rojo', '1992-03-03', 'Calle Gran Vía, 3', 'Valencia', 'Valencia', '777666555', 'pedrogarcia@email.com'),
('45678901D', 'Ana', 'Martínez Cruz', '1993-04-04', 'Calle Princesa, 4', 'Sevilla', 'Sevilla', '755444333', 'anamartinez@email.com'),
('56789012E', 'José', 'González Martín', '1994-05-05', 'Calle Alcalá, 5', 'Málaga', 'Málaga', '733222111', 'josegonzalez@email.com'),
('67890123F', 'Luisa', 'Sánchez Estrella', '1995-06-06', 'Calle Gran Capitán, 6', 'Zaragoza', 'Zaragoza', '622111000', 'luisasanchez@email.com'),
('78901234G', 'Antonio', 'Rodríguez Blanco', '1996-07-07', 'Calle Espoz y Mina, 7', 'Bilbao', 'Bilbao', '611000999', 'antoniorodriguez@email.com'),
('89012345H', 'Carmen', 'Fernández Paez', '1997-08-08', 'Calle Santander, 8', 'Santander', 'Cantabria', '900999888', 'carmenfernandez@email.com'),
('90123456I', 'David', 'Gómez Leo', '1998-09-09', 'Calle Granada, 9', 'Granada', 'Granada', '998887766', 'davidgomez@email.com'),
('91234567J', 'María', 'Martínez Fernández', '1980-05-20', 'Calle Sevilla, 12', 'Sevilla', 'Sevilla', '665544332', 'mariamartinez@email.com'),
('92345678K', 'Juan', 'Pérez Gracia', '1970-02-14', 'Calle Madrid, 15', 'Madrid', 'Madrid', '687766554', 'juanperez@email.com'),
('93456789L', 'Ana', 'López Sancho', '1960-01-01', 'Calle Barcelona, 16', 'Barcelona', 'Barcelona', '776655443', 'analopez@email.com'),
('94567890M', 'Pedro', 'Sánchez Tano', '1950-12-31', 'Calle Valencia, 17', 'Valencia', 'Valencia', '665544331', 'pedrosanches@email.com'),
('95678901N', 'Carmen', 'García Mena', '1940-11-29', 'Calle Zaragoza, 18', 'Zaragoza', 'Zaragoza', '787766552', 'carmengarcia@email.com'),
('96789012O', 'Antonio', 'Rodríguez Tiedra', '1930-10-28', 'Calle Bilbao, 19', 'Bilbao', 'Vizcaya', '776655441', 'antoniorodriguez@email.com'),
('97890123P', 'Luisa', 'González Paniagua', '1920-09-27', 'Calle Sevilla, 20', 'Sevilla', 'Sevilla', '665544330', 'luisagonzalez@email.com'),
('98901234Q', 'José', 'Fernández Santos', '1910-08-26', 'Calle Madrid, 21', 'Madrid', 'Madrid', '687766550', 'josefernandez@email.com'),
('90123456R', 'David', 'Gómez Gil', '1998-09-09', 'Calle Granada, 9', 'Granada', 'Granada', '998887766', 'davidgomez@email.com');

INSERT INTO trabajadores (id_trabajador, rol, usuario, pass, dni_trabajador) VALUES
(1, 'Administrador', 'admin', 'admin', '12345678A'),
(2, 'Educador', 'educador1', 'educador1', '23456789B'),
(3, 'Educador', 'educador2', 'educador2', '34567890C'),
(4, 'Educador', 'educador3', 'educador3', '45678901D'),
(5, 'Educador', 'educador4', 'educador4', '56789012E'),
(6, 'Educador', 'educador5', 'educador5', '67890123F'),
(7, 'Terapeuta', 'terapeuta', 'terapeuta', '78901234G'),
(8, 'Psicólogo', 'psicologo1', 'psicologo1', '89012345H'),
(9, 'Psicólogo', 'psicologo2', 'psicologo2', '90123456I');

INSERT INTO dependientes (id_dependiente, dni_dependiente, nivel_dependencia, num_habitacion, familiar_referencia, nombre_fam_referencia, telefono_fam_referencia) VALUES
/* ('91234567J', 'Grado 2', 2, 'Hermano', 'Jacinto Gutiérrez Gil', '755444333'), */
(1, '90123456R', 'Grado 1', 1, 'Padre', 'Ernesto Calatrava Hernandez', '655444333'),
(2, '91234567J', 'Grado 2', 2, 'Hermano', 'Jacinto Gutiérrez Gil', '755444333'),
(3, '92345678K', 'Grado 1', 3, 'Madre', 'María Fernández Casas', '955444333'),
(4, '93456789L', 'Grado 3', 4, 'Hermana', 'Ana Morán Molina', '675448323'),
(5, '94567890M', 'Grado 1', 5, 'Tío', 'Bernardo Benítez Bautista', '955444222'),
(6, '95678901N', 'Grado 1', 6, 'Tía', 'Eusebia Ríos Pajuelo', '922123456'),
(7, '96789012O', 'Grado 2', 7, 'Padre', 'José Durán Rojas', '655768456'),
(8, '97890123P', 'Grado 1', 8, 'Madre', 'Eugenia Toril Méndez', '786325647'),
(9, '98901234Q', 'Grado 1', 9, 'Hermana', 'Mónica Iglesias Turégano', '611544433');

INSERT INTO incidencias (fecha, descripcion, id_trabajador, id_dependiente) VALUES
('2023-11-25', 'El dependiente se ha caído de la cama', 1, 1),
('2023-11-26', 'El dependiente ha tenido una crisis de ansiedad', 2, 2),
('2023-11-27', 'El dependiente no ha tomado su medicación', 3, 3),
('2023-11-28', 'El dependiente ha tenido un accidente con la comida', 4, 4),
('2023-12-05', 'El dependiente se ha escapado de la residencia', 5, 5),
('2023-12-01', 'El dependiente ha presentado fiebre', 6, 6),
('2023-12-02', 'El dependiente ha tenido una reacción alérgica', 7, 7),
('2023-12-03', 'El dependiente ha sufrido un desmayo', 8, 8),
('2023-12-04', 'El dependiente ha tenido un problema de conducta', 9, 9),
('2023-11-27', 'El dependiente no ha tomado su medicación a su hora', 1, 1),
('2023-12-04', 'El dependiente ha realizado una mala contesteación al educador', 2, 2),
('2023-11-28', 'El dependiente ha tenido un accidente en el baño', 3, 3),
('2023-12-02', 'El dependiente ha tenido una reacción alérgica', 4, 4),
('2023-11-26', 'El dependiente ha tenido una crisis epileptica', 5, 5),
('2023-12-05', 'El dependiente se ha marchado a comer con un familiar', 6, 6),
('2023-12-01', 'El dependiente se encuentra enfermo', 7, 7),
('2023-11-25', 'El dependiente se ha caído al suelo',8, 8),
('2023-12-03', 'El dependiente ha sufrido un patatús', 9, 9);

INSERT INTO CITAS (id_cita, fecha, hora, centro, localidad, provincia, direccion, planta, especialidad, id_dependiente) VALUES
(1, '2023-12-05', '10:00', 'Hospital A', 'Ciudad A', 'Provincia A', 'Calle A #123', 'Planta 1', 'Cardiología', 1),
(2, '2023-12-06', '14:30', 'Clínica B', 'Ciudad B', 'Provincia B', 'Calle B #456', 'Planta 2', 'Dermatología', 2),
(3, '2023-12-07', '09:15', 'Centro C', 'Ciudad C', 'Provincia C', 'Calle C #789', 'Planta 3', 'Psiquiatría', 3),
(4, '2023-12-08', '16:45', 'Hospital D', 'Ciudad D', 'Provincia D', 'Calle D #012', 'Planta 4', 'Oftalmología', 4),
(5, '2023-12-05', '10:00', 'Hospital A', 'Ciudad A', 'Provincia A', 'Calle A #123', 'Planta 1', 'Cardiología', 5),
(6, '2023-12-10', '14:30', 'Clínica B', 'Ciudad B', 'Provincia B', 'Calle B #456', 'Planta 2', 'Dermatología', 6),
(7, '2023-12-09', '09:15', 'Centro C', 'Ciudad C', 'Provincia C', 'Calle C #789', 'Planta 3', 'Psiquiatría', 7),
(8, '2023-12-14', '16:45', 'Hospital D', 'Ciudad D', 'Provincia D', 'Calle D #012', 'Planta 4', 'Oftalmología', 8),
(9, '2023-12-12', '14:30', 'Clínica B', 'Ciudad B', 'Provincia B', 'Calle B #456', 'Planta 2', 'Dermatología', 9);

INSERT INTO CONSULTAS (nombre_medico, motivo_visita, descripcion, diagnostico, id_cita) VALUES
('Dr. Pérez', 'Dolor de cabeza', 'El paciente presenta un dolor de cabeza intenso de varios días de evolución.', 'Migraña', 1),
('Dra. Gómez', 'Fiebre', 'El paciente presenta fiebre alta de 39 grados centígrados.', 'Gripe', 2),
('Dr. Sánchez', 'Tos', 'El paciente presenta tos seca y persistente.', 'Bronquitis', 3),
('Dra. Rodríguez', 'Irritación y dificultad para respirar', 'El paciente presenta una reacción alérgica a un alimento.', 'Alergia a la piña', 4),
('Dr. López', 'Infección de garganta', 'El paciente presenta dolor e inflamación de la garganta.',  'Laringitis',5),
('Dra. Hernández', 'Dolor de estómago', 'El paciente presenta dolor abdominal y náuseas.', 'Gastroenteritis', 6),
('Dr. García', 'Herida', 'El paciente presenta una herida abierta en la pierna.', 'Corte profundo', 7),
('Dra. Martínez', 'Consulta de seguimiento', 'El paciente acude a consulta para el seguimiento de su tratamiento.', 'Seguimiento por enfermedad previa', 8),
('Dr. Fernández', 'Consulta de rutina', 'El paciente acude a consulta para una revisión general.', 'Revisión de analítica anual', 9);

INSERT INTO medicacion (nombre_comercial, principio_activo, concentracion, via_administracion, formato) VALUES
('Paracetamol', 'Paracetamol', '500 mg', 'Oral', 'Tabletas'),
('Ibuprofeno', 'Ibuprofeno', '400 mg', 'Oral', 'Tabletas'),
('Aspirina', 'Acido acetilsalicílico', '100 mg', 'Oral', 'Tabletas'),
('Amlodipino', 'Amlodipino', '5 mg', 'Oral', 'Tabletas'),
('Fenobarbital', 'Fenobarbital', '100 mg', 'Oral', 'Tabletas'),
('Amoxicilina', 'Amoxicilina', '500 mg', 'Oral', 'Tabletas'),
('Levofloxacino', 'Levofloxacino', '500 mg', 'Oral', 'Tabletas'),
('Montelukast', 'Montelukast', '10 mg', 'Oral', 'Tabletas'),
('Salbutamol', 'Salbutamol', '2,5 mg', 'Inhalatoria', 'Inhalador'),
('Haloperidol', 'Haloperidol', '2 mg', 'Oral', 'Tabletas'),
('Sertralina', 'Sertralina', '50 mg', 'Oral', 'Tabletas'),
('Fluoxetina', 'Fluoxetina', '20 mg', 'Oral', 'Tabletas'),
('Paroxetina', 'Paroxetina', '20 mg', 'Oral', 'Tabletas'),
('Litio', 'Litio', '900 mg', 'Oral', 'Tabletas'),
('Clonazepam', 'Clonazepam', '0,5 mg', 'Oral', 'Tabletas'),
('Tranxilium', 'Diazepam', '10 mg', 'Oral', 'Tabletas'),
('Noctamid', 'Zolpidem', '10 mg', 'Oral', 'Tabletas');

INSERT INTO tratamientos (sintoma, pauta_medicacion, pauta_reducida, tipo, fecha_inicio, fecha_fin, id_consulta, id_medicamento) VALUES
('Gripe', 'Paracetamol 1 g cada 8 horas', '1-1-0-1' , 'Ambulatorio', '2023-11-25', '2023-12-02', 1, 1),
('Dolor de cabeza', 'Ibuprofeno 400 mg cada 6 horas', '1-1-1-1 (6am)' , 'Ambulatorio', '2023-11-26', '2023-11-28', 2, 2),
('Alergia', 'Montelukast 10 mg una vez al día', '1-0-0-0' , 'Ambulatorio', '2023-11-27', '2024-03-27', 3, 9),
('Asma', 'Salbutamol 2,5 mg cada 6 horas', null , 'Ambulatorio', '2023-11-28', '2024-03-28', 4, 10),
('Hipertensión', 'Amlodipino 5 mg una vez al día', '0-0-0-1' , 'Ambulatorio', '2023-11-29', '2024-03-29', 5, 4),
('Infección de orina', 'Amoxicilina 500 mg cada 8 horas', '1-1-0-1' , 'Ambulatorio', '2023-11-30', '2023-12-06', 6, 5),
('Bronquitis', 'Levofloxacino 500 mg una vez al día', '1-0-0-0' , 'Hospitalario', '2023-12-01', '2023-12-10', 7, 6),
('Epilepsia', 'Fenobarbital 100 mg tres veces al día', '1-1-0-1' , 'Ambulatorio', '2023-12-02', '2024-03-02', 8, 3),
('Trastorno depresivo mayor', 'Sertralina 50 mg una vez al día', '1-0-0-0' , 'Psiquiatrica', '2023-11-25', '2024-03-25', 9, 11),
('Trastorno de ansiedad generalizada', 'Escitalopram 10 mg una vez al día', '1-0-0-0' , 'Psiquiatrica', '2023-11-26', '2024-03-26', 1, 12),
('Trastorno bipolar', 'Litio 900 mg una vez al día', '0-0-1-0' , 'Psiquiatrica', '2023-11-27', '2024-03-27', 2, 13),
('Esquizofrenia', 'Haloperidol 2 mg tres veces al día', '1-1-0-1' , 'Psiquiatrica', '2023-11-28', '2024-03-28', 3, 14),
('Trastorno obsesivo-compulsivo', 'Fluoxetina 20 mg una vez al día', '0-1-0-0' , 'Psiquiatrica', '2023-11-29', '2024-03-29', 4, 15),
('Trastorno de estrés postraumático', 'Paroxetine 20 mg una vez al día', '1-0-0-0' , 'Psiquiatrica', '2023-11-30', '2024-03-30', 5, 16),
('Trastorno por déficit de atención e hiperactividad', 'Metilfenidato 10 mg dos veces al día', '1-0-0-1' , 'Psiquiatrica', '2023-12-01', '2024-03-01', 6, 17);