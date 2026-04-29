-- ============================================
-- ATM Audit Management System - Clean Setup
-- ============================================

CREATE DATABASE IF NOT EXISTS atm_audit
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE atm_audit;

-- 1. ATMs Table (Local storage audit tracking ke liye)
CREATE TABLE IF NOT EXISTS atms (
  id              INT           NOT NULL AUTO_INCREMENT,
  terminal        VARCHAR(100)  NOT NULL DEFAULT '',
  address          TEXT          NOT NULL,
  area            VARCHAR(150)  NOT NULL DEFAULT '',
  maps            TEXT          NOT NULL DEFAULT '',
  audit_status    TINYINT(1)    NOT NULL DEFAULT 0,
  last_audit_date DATE          DEFAULT NULL,
  created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Users Table
CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Simple Login Insert (No Hash)
-- Username: admin | Password: 123
INSERT INTO users (username, password) VALUES 
('admin', '123');

-- 4. Sample ATM Data (Vyara, Songadh, Bardoli areas)
INSERT INTO atms (terminal, address, area, maps, audit_status, last_audit_date) VALUES
  ('ATM-001', 'Branch Road, Near Post Office', 'Vyara',   'https://www.google.com/maps?q=Vyara', 0, NULL),
  ('ATM-002', 'Main Bazaar, Opp. SBI',         'Songadh', 'https://www.google.com/maps?q=Songadh', 0, NULL),
  ('ATM-003', 'Station Road, Platform Gate',   'Bardoli', '', 0, NULL);
