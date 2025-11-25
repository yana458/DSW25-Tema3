ALTER TABLE posts
    ADD COLUMN category_id INT NULL;

ALTER TABLE posts
    ADD CONSTRAINT fk_posts_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL;
