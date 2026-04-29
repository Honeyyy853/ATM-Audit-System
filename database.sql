-- ============================================
-- ATM Audit Management System - Database Setup
-- Run this in phpMyAdmin or MySQL CLI
-- ============================================

CREATE DATABASE IF NOT EXISTS atm_audit
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE atm_audit;

CREATE TABLE IF NOT EXISTS atms (
  id              INT           NOT NULL AUTO_INCREMENT,
  terminal        VARCHAR(100)  NOT NULL DEFAULT '',
  address         TEXT          NOT NULL,
  area            VARCHAR(150)  NOT NULL DEFAULT '',
  maps            TEXT          NOT NULL DEFAULT '',
  audit_status    TINYINT(1)    NOT NULL DEFAULT 0,
  last_audit_date DATE          DEFAULT NULL,
  created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Placeholder user (username: demo_user, password: your_password_here)
-- The password hash uses bcrypt (generate using password_hash() in PHP)
INSERT INTO users (username, password) VALUES 
('demo_user', '$2y$10$wO3Pudq1iT2oR1k2AOHX2.nQYl2Wlk7OOf2Zl8Z14hF/t9oH2e5y.');

-- Optional: seed a few sample rows to test
INSERT INTO atms (terminal, address, area, maps, audit_status, last_audit_date) VALUES
  ('ATM-001', 'Branch Road, Near Post Office', 'Vyara',   'https://maps.google.com/?q=Vyara', 0, NULL),
  ('ATM-002', 'Main Bazaar, Opp. SBI',         'Songadh', 'https://maps.google.com/?q=Songadh', 0, NULL),
  ('ATM-003', 'Station Road, Platform Gate',   'Bardoli', '', 0, NULL);
