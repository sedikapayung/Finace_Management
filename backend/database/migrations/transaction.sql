CREATE TABLE IF NOT EXISTS transaction(
    id BIGSERIAL PRIMARY KEY NOT NULL, 
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE, 
    wallet_id BIGINT NOT NULL REFERENCES wallets(id) ON DELETE RESTRICT ,
    to_Wallet_id BIGINT REFERENCES wallets(id) ON DELETE RESTRICT,
    category_id BIGINT NOT NULL REFERENCES category(id) ON DELETE RESTRICT, 
    type VARCHAR(10) NOT NULL CHECK(type IN ('income', 'expense', 'transfer')),
    amount DECIMAL(15,2) NOT NULL CHECK (amount  > 0),
    note VARCHAR(255),
    trx_date DATE NOT NULL,
    created_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_trx_shape CHECK(
        (type = 'transfer' AND to_wallet_id IS NOT NULL AND category_id IS NULL AND to_wallet_id<> wallet_id) or 
        (type <> 'transfer' AND to_wallet_id IS NULL AND category_id IS NOT NULL )
    )
);

CREATE INDEX IF NOT EXISTS idx_trx_user_date ON transaction (user_id, trx_date DESC);
CREATE INDEX IF NOT EXISTS  idx_user_wallet ON transaction (user_id, wallet_id);
CREATE INDEX IF NOT EXISTS idx_trx_user_category_date ON transaction (user_id, category_id, trx_date); 