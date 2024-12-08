
M-DNS Blog
==========

Açık kaynaklı, kullanıcı dostu ve dinamik bir blog sistemi

Özellikler
----------

*   Dinamik içerik yönetimi: Blog gönderileri ve kategoriler kolayca düzenlenebilir.
*   Markdown desteği: Gönderilerde basit biçimlendirme.
*   Görüntüleme sayacı: Her yazının okunma sayısını takip edin.
*   Bootstrap 5 ile modern ve mobil uyumlu tasarım.
*   GitHub tarzında şık bir arayüz.

Kurulum
-------

Bu projeyi kendi ortamınıza kurmak için aşağıdaki adımları izleyin:

1.  **Depoyu Klonlayın:**
    
        git clone https://github.com/username/mdns-blog.git
        cd mdns-blog
    
2.  **Veritabanını Ayarlayın:**
    
    *   \`blogdns\` adında bir veritabanı oluşturun.
    *   Projeyle birlikte gelen `blogdns.sql` dosyasını şu komutla içe aktarın:
    
        mysql -u your_username -p blogdns < blogdns.sql
    
3.  **Veritabanı Bağlantısını Yapılandırın:**
    
    `includes/db.php` dosyasını açın ve aşağıdaki alanları düzenleyin:
    
        
        $host = 'localhost';
        $dbname = 'blogdns';
        $username = 'your_username';
        $password = 'your_password';
    
4.  **Web Sunucusunu Yapılandırın:**
    
    Projeyi yerel sunucunuzda kök dizine ayarlayın ve çalıştırın.
    

Ekran Görüntüleri
-----------------

Aşağıda proje ile ilgili ekran görüntülerini bulabilirsiniz:

### Ana Sayfa
![Ana Sayfa](https://m-dns.org/media/blog1.png)

### Blog Yazısı Görünümü
![Blog Yazısı Görünümü](https://m-dns.org/media/blog2.png)

### Yönetici Paneli - Gönderi Yönetimi
![Yönetici Paneli - Gönderi Yönetimi](https://m-dns.org/media/blog3.png)

### Yönetici Paneli - Kategori Yönetimi
![Yönetici Paneli - Kategori Yönetimi](https://m-dns.org/media/blog4.png)

### Blog Ayarları
![Blog Ayarları](https://m-dns.org/media/blog5.png)

Katkıda Bulunma
---------------

Projeyi geliştirmek isterseniz, katkılarınızı bekliyoruz! Aşağıdaki adımları takip edin:

1.  Bu depoyu fork'layın.
2.  Yeni bir dal oluşturun: `git checkout -b feature/your-feature`
3.  Değişikliklerinizi yapın ve commit edin: `git commit -m "Add your feature"`
4.  Pull Request gönderin: `git push origin feature/your-feature`

Lisans
------

Bu proje **MIT Lisansı** altında lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasını inceleyebilirsiniz.

© 2024 M-DNS Blog. Tüm hakları saklıdır.
