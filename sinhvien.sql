CREATE TABLE sinhvien (
    id SERIAL PRIMARY KEY,
    hoten VARCHAR(100) NOT NULL,
    mssv VARCHAR(8) NOT NULL UNIQUE
);
