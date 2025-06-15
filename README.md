# 🗡️ Tarihsel Silah Kataloğu

**Web Tabanlı Programlama dersi kapsamında geliştirilmiş profesyonel bir tarihsel silah katalog uygulaması**

[Kurulum](#-kurulum) • [Özellikler](#-özellikler) • [Kullanım](#-kullanım) • [Katkıda Bulunma](#-katkıda-bulunma)

---

## 📋 İçindekiler

- [Proje Hakkında](#-proje-hakkında)
- [Özellikler](#-özellikler)
- [Teknolojiler](#️-teknolojiler)
- [Kurulum](#-kurulum)
- [Dosya Yapısı](#-dosya-yapısı)
- [Kullanım](#-kullanım)
- [Veritabanı Yapısı](#️-veritabanı-yapısı)
- [Ekran Görüntüleri](#-ekran-görüntüleri)
- [Katkıda Bulunma](#-katkıda-bulunma)
- [Lisans](#-lisans)

---

## 🎯 Proje Hakkında

**Tarihsel Silah Kataloğu**, tarihsel silahların dijital bir koleksiyonunu oluşturmak amacıyla geliştirilmiş modern bir web uygulamasıdır. Bu uygulama sayesinde kullanıcılar:

- 📚 Tarihsel silahları keşfedebilir
- ➕ Yeni silah kayıtları ekleyebilir
- ✏️ Mevcut kayıtları düzenleyebilir
- 🔍 Gelişmiş arama ve filtreleme yapabilir
- 👤 Kişisel profil yönetimi gerçekleştirebilir

---

## ✨ Özellikler

### 👥 Kullanıcı Yönetimi
- **Kayıt Sistemi**: Güvenli kullanıcı kaydı
- **Giriş/Çıkış**: Oturum yönetimi
- **Profil Yönetimi**: Kullanıcı bilgilerini güncelleme
- **Şifre Güvenliği**: Gelişmiş şifreleme sistemi

### ⚔️ Silah Yönetimi
- **CRUD İşlemleri**: Tam kapsamlı veri yönetimi
- **Gelişmiş Arama**: Çoklu kriterlerde filtreleme
- **Detaylı Görünüm**: Kapsamlı silah bilgileri
- **Görsel Yönetim**: Fotoğraf yükleme ve görüntüleme

### 🔒 Güvenlik
- **Şifre Hashleme**: `password_hash()` ile güvenli şifreleme
- **Oturum Kontrolü**: Güvenli oturum yönetimi
- **Veri Doğrulama**: İstemci ve sunucu tarafı kontroller
- **SQL Injection Koruması**: Prepared statements kullanımı

### 🎨 Kullanıcı Arayüzü
- **Responsive Tasarım**: Bootstrap 5.3 ile mobil uyumlu
- **Modern İkonlar**: Font Awesome 6.4 entegrasyonu
- **Dinamik Özellikler**: JavaScript ile etkileşimli arayüz
- **Kullanıcı Dostu**: Sezgisel navigasyon

---

## 🛠️ Teknolojiler

| Kategori | Teknoloji | Versiyon |
|----------|-----------|----------|
| **Backend** | PHP | 7.4+ |
| **Veritabanı** | MySQL | 5.7+ |
| **Frontend** | HTML5, CSS3 | - |
| **Framework** | Bootstrap | 5.3 |
| **İkonlar** | Font Awesome | 6.4 |
| **JavaScript** | Vanilla JS | ES6+ |
| **Karakter Seti** | UTF8MB4 | - |

---

## 🚀 Kurulum

### Gereksinimler

- **XAMPP** (Apache + PHP + MySQL)
- **PHP** 7.4 veya üstü
- **MySQL** 5.7 veya üstü
- Modern web tarayıcı (Chrome, Firefox, Safari, Edge)

### Kurulum Adımları

1. **XAMPP Kurulumu**
   ```bash
   # XAMPP'ı indirin ve kurun
   # Apache ve MySQL servislerini başlatın
   ```

2. **Proje Dosyalarını Kopyalama**
   ```bash
   # Proje dosyalarını XAMPP htdocs dizinine kopyalayın
   cp -r historical-weapons-catalog C:/xampp/htdocs/
   ```

3. **Veritabanı Kurulumu**
   ```sql
   -- MySQL'de sql/database.sql dosyasını çalıştırın
   SOURCE C:/xampp/htdocs/historical-weapons-catalog/sql/database.sql;
   ```

4. **Konfigürasyon**
   ```php
   // config/database.php dosyasındaki ayarları kontrol edin
   $host = 'localhost';
   $dbname = 'historical_weapons';
   $username = 'root';
   $password = '';
   ```

5. **Uygulamayı Başlatma**
   ```
   http://localhost/historical-weapons-catalog/
   ```

---

## 📁 Dosya Yapısı

```
historical-weapons-catalog/
├── 📄 index.php                 # Ana sayfa
├── 📄 ai.md                     # AI desteği dokümantasyonu
├── 📄 README.md                 # Proje dokümantasyonu
├── 📂 config/
│   └── 📄 config.php          # Veritabanı bağlantı ayarları
├── 📂 auth/
│   ├── 📄 login.php            # Giriş sayfası
│   ├── 📄 register.php         # Kayıt sayfası
│   ├── 📄 logout.php           # Çıkış işlemi
│   └── 📄 profile.php          # Profil düzenleme
├── 📂 weapons/
│   ├── 📄 add.php              # Yeni silah ekleme
│   ├── 📄 list.php             # Silah listesi
│   ├── 📄 edit.php             # Silah düzenleme
│   ├── 📄 delete.php           # Silah silme
│   └── 📄 view.php             # Silah detay görünümü
├── 📂 classes/
│   ├── 📄 Database.php         # Veritabanı sınıfı
│   ├── 📄 User.php             # Kullanıcı sınıfı
│   └── 📄 Weapon.php           # Silah sınıfı
├── 📂 includes/
│   ├── 📄 header.php           # Sayfa üst kısmı
│   ├── 📄 footer.php           # Sayfa alt kısmı
│   └── 📄 session_check.php    # Oturum kontrolü
├── 📂 css/
│   └── 📄 style.css            # CSS dosyaları
├── 📂 js/
│   └── 📄 script.js            # JavaScript dosyaları
├── 📂 images/             
└── 📂 sql/
    └── 📄 database.sql         # Veritabanı kurulum scripti
```

---

## 📖 Kullanım

### 🔐 Hesap İşlemleri

#### Kayıt Olma
1. `/auth/register.php` adresine gidin
2. Gerekli bilgileri doldurun:
   - Kullanıcı adı
   - E-posta adresi
   - Ad Soyad
   - Şifre
3. "Kayıt Ol" butonuna tıklayın
4. Otomatik olarak giriş sayfasına yönlendirileceksiniz

#### Giriş Yapma
1. `/auth/login.php` adresine gidin
2. Kullanıcı adı/e-posta ve şifrenizi girin
3. "Giriş Yap" butonuna tıklayın

### ⚔️ Silah Yönetimi

#### Yeni Silah Ekleme
1. `/weapons/add.php` adresine gidin
2. Silah bilgilerini doldurun:
   - Silah adı
   - Tipi
   - Menşei ülke
   - Üretim yılı
   - Tarihsel dönem
   - Malzeme
   - Boyutlar
   - Durum
   - Açıklama
3. İsteğe bağlı fotoğraf yükleyin
4. "Ekle" butonuna tıklayın

#### Silah Listeleme ve Arama
1. `/weapons/list.php` adresine gidin
2. Arama çubuğunu kullanarak filtreleme yapın
3. Sıralama seçeneklerini kullanın
4. Detay görünümü için silah adına tıklayın

---

## 📱 Ekran Görüntüleri

### 🏠 Ana Sayfa
![Ana Sayfa](images/ana-sayfa.png)
*Modern ve kullanıcı dostu ana sayfa tasarımı - İstatistikler ve navigasyon menüsü*

### 🔐 Giriş Sayfası
![Giriş Sayfası](images/giris-sayfasi.png)
*Güvenli kullanıcı girişi - Modern form tasarımı*

### 📝 Kayıt Sayfası
![Kayıt Sayfası](images/kayit-sayfasi.png)
*Yeni kullanıcı kaydı - Kullanıcı dostu form alanları*

### ➕ Silah Ekleme
![Silah Ekleme](images/silah-ekleme.png)
*Yeni silah kayıt formu - Detaylı bilgi giriş alanları*

### 📋 Silah Listesi
![Silah Listesi](images/silah-listesi.png)
*Gelişmiş arama ve filtreleme özellikleri - Tablo görünümü*

### 🎨 Arayüz Özellikleri

**Dinamik Özellikler:**
- Smooth animasyonlar ve geçişler
- Canlı arama ve filtreleme
- İnteraktif veri görselleştirme
- Kullanıcı dostu navigasyon

**Görsel Tasarım:**
- Modern ve minimalist tasarım
- Dark theme desteği
- Bootstrap 5.3 responsive grid sistemi
- Font Awesome ikonları

**Responsive Tasarım:**
- Mobil uyumlu arayüz
- Tablet ve desktop desteği
- Esnek layout yapısı
- Touch-friendly butonlar

---

## 📄 Lisans

Bu proje MIT Lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakın.