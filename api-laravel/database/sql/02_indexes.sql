-- ============================================================
-- TSA Backend Assessment - Database Indexes
-- ============================================================
USE nxm_assessment_2023;

-- Indexes for performance optimization
CREATE INDEX IF NOT EXISTS idx_orders_order_date ON orders(order_date);
CREATE INDEX IF NOT EXISTS idx_users_user_type ON users(user_type);
CREATE INDEX IF NOT EXISTS idx_users_referred_by ON users(referred_by);
CREATE INDEX IF NOT EXISTS idx_users_referred_by_type_date ON users(referred_by, user_type, joined_date);
CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items(order_id);
CREATE INDEX IF NOT EXISTS idx_orders_user_id ON orders(user_id);
CREATE INDEX IF NOT EXISTS idx_orders_invoice ON orders(invoice);

-- Views for reporting
CREATE OR REPLACE VIEW v_order_commission_report AS
SELECT 
    o.id AS order_id,
    o.invoice,
    o.order_date,
    o.user_id AS purchaser_id,
    CONCAT(purchaser.first_name, ' ', purchaser.last_name) AS purchaser_name,
    purchaser.user_type AS purchaser_type,
    referrer.id AS distributor_id,
    CONCAT(referrer.first_name, ' ', referrer.last_name) AS distributor_name,
    referrer.user_type AS referrer_type,
    (
        SELECT COUNT(*)
        FROM users AS referred
        WHERE referred.referred_by = referrer.id
        AND referred.user_type = 'Distributor'
        AND referred.joined_date <= o.order_date
    ) AS referred_distributors,
    (
        SELECT COALESCE(SUM(oi.price * oi.quantity), 0)
        FROM order_items oi
        WHERE oi.order_id = o.id
    ) AS order_total
FROM orders o
INNER JOIN users purchaser ON o.user_id = purchaser.id
LEFT JOIN users referrer ON purchaser.referred_by = referrer.id 
    AND referrer.user_type = 'Distributor'
ORDER BY o.order_date DESC, o.invoice ASC;

-- View: Distributor sales totals
CREATE OR REPLACE VIEW v_distributor_sales AS
SELECT 
    d.id AS distributor_id,
    CONCAT(d.first_name, ' ', d.last_name) AS distributor_name,
    COALESCE(
        (
            SELECT SUM(oi.price * oi.quantity)
            FROM users AS referred
            INNER JOIN orders o ON o.user_id = referred.id
            INNER JOIN order_items oi ON oi.order_id = o.id
            WHERE referred.referred_by = d.id
        ),
        0
    ) AS total_sales
FROM users d
WHERE d.user_type = 'Distributor'
HAVING total_sales > 0
ORDER BY total_sales DESC;
