CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE weapons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    origin_country VARCHAR(50),
    manufacture_year INT,
    historical_period VARCHAR(100),
    material VARCHAR(100),
    length_cm DECIMAL(5,2),
    weight_kg DECIMAL(5,2),
    condition_status ENUM('Mükemmel', 'İyi', 'Orta', 'Kötü') DEFAULT 'İyi',
    description TEXT,
    acquisition_date DATE,
    estimated_value DECIMAL(10,2),
    image_url VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (username, email, password_hash, full_name)
VALUES
('ahmety', 'ahmet@example.com', 'hash123', 'Ahmet Yılmaz'),
('ecey', 'melisa@example.com', 'hash456', 'Ece Yılmaz'),
('beyzk', 'kadir@example.com', 'hash789', 'Beyza Bektaş'),
('ayseoz', 'ayse@example.com', 'hashabc', 'Ayşe Özdemir'),
('mertc', 'mert@example.com', 'hashdef', 'Mert Can');



INSERT INTO weapons (
    name, type, origin_country, manufacture_year, historical_period, material,
    length_cm, weight_kg, condition_status, description,
    acquisition_date, estimated_value, image_url, created_by
) VALUES
-- Modern Silahlar (Son 100 yıl)
('M16A4', 'Tüfek', 'ABD', 1998, 'Modern Dönem', 'Çelik ve Polimer', 100.00, 3.50, 'İyi', 'ABD ordusu tarafından kullanılan modern piyade tüfeği.', '2020-06-01', 1500.00, 'm16a4.jpg', 1),
('AK-47', 'Tüfek', 'Rusya', 1949, 'Soğuk Savaş', 'Çelik ve Ahşap', 87.00, 4.30, 'İyi', 'Dünyanın en yaygın kullanılan saldırı tüfeği.', '2019-03-12', 1200.00, 'ak47.jpg', 2),
('Glock 17', 'Tabanca', 'Avusturya', 1982, 'Modern Dönem', 'Polimer ve Çelik', 20.00, 0.90, 'Mükemmel', 'Hafif ve güvenilir tabanca.', '2021-01-20', 800.00, 'glock17.jpg', 1),
('Heckler & Koch MP5', 'Makinalı Tabanca', 'Almanya', 1966, 'Soğuk Savaş', 'Çelik', 68.00, 2.50, 'İyi', 'Özel kuvvetlerin tercih ettiği silah.', '2022-11-30', 2000.00, 'mp5.jpg', 3),
('FN SCAR-H', 'Tüfek', 'Belçika', 2004, 'Modern Dönem', 'Alüminyum Alaşım', 99.00, 3.90, 'Mükemmel', 'Gelişmiş modüler piyade tüfeği.', '2023-02-05', 3000.00, 'scarh.jpg', 2),
('Barrett M82', 'Keskin Nişancı Tüfeği', 'ABD', 1989, 'Modern Dönem', 'Çelik', 144.00, 14.00, 'İyi', 'Anti-materyal tüfeği.', '2018-07-12', 9000.00, 'barrett.jpg', 4),
('SIG Sauer P226', 'Tabanca', 'Almanya', 1984, 'Modern Dönem', 'Çelik', 19.60, 0.95, 'İyi', 'Polis ve askeri kuvvetlerde yaygın.', '2020-08-15', 950.00, 'p226.jpg', 5),
('Steyr AUG', 'Tüfek', 'Avusturya', 1977, 'Modern Dönem', 'Polimer ve Çelik', 79.00, 3.60, 'İyi', 'Bullpup tipi saldırı tüfeği.', '2021-04-22', 2500.00, 'aug.jpg', 3),
('M9 Beretta', 'Tabanca', 'İtalya', 1985, 'Modern Dönem', 'Çelik', 21.60, 0.96, 'İyi', 'ABD ordusunda standart hizmet tabancasıydı.', '2022-06-19', 780.00, 'beretta.jpg', 4),
('Uzi', 'Makinalı Tabanca', 'İsrail', 1950, 'Soğuk Savaş', 'Çelik', 64.00, 3.50, 'Orta', 'Kompakt makinalı tabanca.', '2017-09-25', 1400.00, 'uzi.jpg', 2),

-- Tarihî Silahlar
('Katana', 'Kılıç', 'Japonya', 1600, 'Edo Dönemi', 'Çelik', 70.00, 1.10, 'İyi', 'Samuraylar tarafından kullanılan geleneksel Japon kılıcı.', '2010-05-15', 10000.00, 'katana.jpg', 1),
('Gladius', 'Kılıç', 'Roma', -100, 'Antik Roma', 'Çelik', 60.00, 1.20, 'Orta', 'Roma lejyonerlerinin kullandığı kısa kılıç.', '2009-10-10', 8000.00, 'gladius.jpg', 2),
('Longbow', 'Yay', 'İngiltere', 1400, 'Orta Çağ', 'Ahşap', 180.00, 1.50, 'İyi', 'İngiliz uzun yayı.', '2008-08-08', 6000.00, 'longbow.jpg', 3),
('Yatagan', 'Kılıç', 'Osmanlı', 1700, 'Osmanlı Dönemi', 'Çelik', 65.00, 1.00, 'İyi', 'Osmanlı askeri tarafından taşınan kısa kılıç.', '2007-11-11', 7000.00, 'yatagan.jpg', 4),
('Tomahawk', 'Balta', 'Kızılderili', 1800, 'Kızılderili Kültürü', 'Demir', 45.00, 1.30, 'Orta', 'Kızılderililer tarafından kullanılan savaş baltası.', '2006-12-12', 5000.00, 'tomahawk.jpg', 5),
('Claymore', 'Kılıç', 'İskoçya', 1500, 'Orta Çağ', 'Çelik', 140.00, 2.80, 'İyi', 'İskoçya\'nın çift elli kılıcı.', '2015-03-03', 8500.00, 'claymore.jpg', 3),
('Sabre', 'Kılıç', 'Fransa', 1800, 'Napolyon Dönemi', 'Çelik', 100.00, 1.40, 'İyi', 'Süvariler için kıvrımlı kılıç.', '2011-01-01', 7800.00, 'sabre.jpg', 1),
('Halberd', 'Zıpkın', 'Almanya', 1600, 'Orta Çağ', 'Çelik ve Ahşap', 200.00, 3.20, 'Kötü', 'Uzun saplı savaş silahı.', '2005-05-05', 4000.00, 'halberd.jpg', 2),
('Scimitar', 'Kılıç', 'Ortadoğu', 1500, 'İslam Dönemi', 'Çelik', 85.00, 1.30, 'Orta', 'Kıvrık, tek taraflı kılıç.', '2003-04-04', 6000.00, 'scimitar.jpg', 4),
('Rapier', 'Kılıç', 'İspanya', 1600, 'Rönesans', 'Çelik', 110.00, 1.10, 'İyi', 'İnce ve hafif düellocu kılıcı.', '2012-02-02', 7200.00, 'rapier.jpg', 5);
('M2 Browning', 'Ağır Makineli Tüfek', 'ABD', 1933, 'II. Dünya Savaşı', 'Çelik', 165.00, 38.00, 'İyi', 'Uzun yıllar boyunca birçok cephede kullanılan 12.7 mm kalibreli ağır makineli tüfek.', '2019-01-10', 12000.00, 'm2_browning.jpg', 2),
('DShK 38', 'Ağır Makineli Tüfek', 'Sovyetler Birliği', 1938, 'II. Dünya Savaşı', 'Çelik', 162.00, 34.00, 'Orta', 'Sovyet yapımı 12.7 mm makineli tüfek.', '2017-08-20', 9000.00, 'dshk.jpg', 3),
('RPG-7', 'Tanksavar', 'Rusya', 1961, 'Soğuk Savaş', 'Çelik', 95.00, 7.90, 'İyi', 'Omuzdan atılan tanksavar silahı.', '2020-03-30', 5000.00, 'rpg7.jpg', 1),
('M224 Havan', 'Havan', 'ABD', 1978, 'Modern Dönem', 'Çelik', 127.00, 21.10, 'İyi', '60mm çapında hafif havan silahı.', '2021-12-05', 7000.00, 'm224.jpg', 5),
('Carl Gustaf M4', 'Tanksavar', 'İsveç', 2014, 'Modern Dönem', 'Çelik ve Kompozit', 106.50, 6.70, 'Mükemmel', 'Çok amaçlı tanksavar roketatar sistemi.', '2023-07-14', 9500.00, 'carlgustaf.jpg', 4);

