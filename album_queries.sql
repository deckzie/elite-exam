-- Create database
CREATE DATABASE IF NOT EXISTS album_sales_db;
USE album_sales_db;

-- Drop table if it already exists
DROP TABLE IF EXISTS album_sales;

-- Create table structure
CREATE TABLE album_sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artist VARCHAR(255),
    album VARCHAR(255),
    sales DECIMAL(12,2),
    date_released VARCHAR(20),
    last_update VARCHAR(20)
);

-- Import CSV data
-- Adjust the path to where your CSV file is located
LOAD DATA LOCAL INFILE 'Data Reference (ALBUM SALES).csv'
INTO TABLE album_sales
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(artist, album, sales, date_released, last_update);

-- 1. Display total number of albums sold per artist
SELECT artist, COUNT(*) AS total_albums
FROM album_sales
GROUP BY artist;


-- 2. Display combined album sales per artist
SELECT artist, SUM(sales) AS combined_sales
FROM album_sales
GROUP BY artist;

-- 3. Display the top 1 artist who sold most combined album sales
SELECT artist
FROM album_sales
GROUP BY artist
ORDER BY SUM(sales) DESC
LIMIT 1;

-- 4. Display the top 10 albums per year based on their number of sales
SELECT album, sales
FROM album_sales
ORDER BY sales DESC
LIMIT 10;

-- 5. Display list of albums based on the searched artist
SELECT album
FROM album_sales
WHERE artist = 'Enhypen';
