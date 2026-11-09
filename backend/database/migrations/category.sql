CREATE TABLE IF NOT EXISTS category (
    id BIGSERIAL NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name VARCHAR(60) NOT NULL,
    type VARCHAR (60) NOT NULL CHECK (type IN ('INCOME', 'EXPENSE')),
    icom VARCHAR (255) NULL,
    color CHAR(7),
    is_default BOOLEAN NOT NULL DEFAULT FALSE,
    created_At  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_At TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (user_id, type, name)
);
CREATE INDEX IF NOT EXISTS idx_user_category ON category(user_id, type)