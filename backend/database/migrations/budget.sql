CREATE TABLE IF NOT EXISTS budget(
    id BIGSERIAL NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id BIGINT NOT NULL REFERENCES category(id) ON DELETE CASCADE, 
    periode_month DATE NOT NULL,
    amount_limit DECIMAL (15,2) NOT NULL CHECK (amount_limit > 0),
    created_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (user_id, category_id, periode_month)
)