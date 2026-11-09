-- Migration: add_balance_to_wallets
-- Created at :2026-11-07 04:48:16

ALTER TABLE wallets ADD COLUMN IF NOT EXISTS balance DECIMAL(15,2) NOT NULL DEFAULT 0.00;