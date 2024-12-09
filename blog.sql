-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 08 Ara 2024, 23:27:37
-- Sunucu sürümü: 10.11.10-MariaDB-ubu2204
-- PHP Sürümü: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `blogdns`
--
CREATE DATABASE IF NOT EXISTS `blogdns` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blogdns`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Dökümanlar', 'd-k-manlar'),
(2, 'Araçlar', 'ara-lar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category_id`, `image`, `created_at`, `views`) VALUES
(1, 'Mail DNS Kayıtları ve İşlevleri', 'E-posta DNS Kayıtları ve İşlevleri\r\n\r\nE-posta hizmetlerinin doğru ve güvenli bir şekilde çalışması için DNS (Domain Name System) kritik bir rol oynar. DNS, e-posta trafiğini yönlendiren kayıtlar ve güvenlik protokolleri sağlar. Bu makalede, e-posta DNS kayıtları ve bunların işlevleri hakkında detaylı bilgi bulabilirsiniz.\r\nE-posta DNS Kayıt Türleri\r\n\r\n    MX (Mail Exchange) Kaydı\r\n        MX kaydı, bir alan adıyla ilişkili e-posta sunucusunu tanımlar.\r\n        E-posta gönderilirken, gönderen sunucu, alıcı alan adının MX kaydını sorgular ve mesajı bu kayıtta belirtilen sunucuya teslim eder.\r\n        Örnek:\r\n\r\n    example.com.  IN  MX  10 mail.example.com.\r\n\r\n    Bu kayıt, example.com için önceliği 10 olan mail.example.com sunucusunu tanımlar.\r\n\r\nSPF (Sender Policy Framework) Kaydı\r\n\r\n    SPF, hangi sunucuların alan adınız üzerinden e-posta göndermesine izin verildiğini tanımlar.\r\n    Gönderen kimliğini doğrulamaya yardımcı olur ve spam veya kimlik avı saldırılarını önler.\r\n    Örnek:\r\n\r\n    example.com.  IN  TXT  \"v=spf1 ip4:192.168.1.1 -all\"\r\n\r\nDKIM (DomainKeys Identified Mail) Kaydı\r\n\r\n    DKIM, e-postalara dijital bir imza ekleyerek gönderici kimliğini doğrular.\r\n    Bu kayıt, mesajın değiştirilmediğini ve meşru bir kaynaktan gönderildiğini garantiler.\r\n    Örnek:\r\n\r\n    default._domainkey.example.com.  IN  TXT  \"v=DKIM1; k=rsa; p=public_key\"\r\n\r\nDMARC (Domain-based Message Authentication, Reporting, and Conformance) Kaydı\r\n\r\n    DMARC, SPF ve DKIM doğrulamasını birleştirerek e-posta sahtekarlığını engeller.\r\n    Ayrıca, e-posta doğrulama sonuçları hakkında rapor gönderir.\r\n    Örnek:\r\n\r\n        _dmarc.example.com.  IN  TXT  \"v=DMARC1; p=quarantine; rua=mailto:dmarc-reports@example.com\"\r\n\r\nE-posta DNS Kayıtlarının Önemi\r\n\r\n    E-posta Teslimatı\r\n        Doğru yapılandırılmış DNS kayıtları, e-postalarınızın spam klasörüne düşmeden alıcıya ulaşmasını sağlar.\r\n\r\n    Güvenlik\r\n        SPF, DKIM ve DMARC gibi kayıtlar, alan adınızın kötüye kullanılmasını önler.\r\n\r\n    Alan Adı Güvenilirliği\r\n        DNS kayıtları, alan adınızın güvenilir ve profesyonel bir gönderici olarak tanınmasını sağlar.\r\n\r\nE-posta DNS Kayıtlarının Yapılandırılması\r\n\r\nDNS kayıtlarını yapılandırırken şu adımları takip edebilirsiniz:\r\n\r\n    Alan adı yönetim panelinize giriş yapın.\r\n    DNS ayarları sekmesine gidin.\r\n    Gerekli MX, SPF, DKIM ve DMARC kayıtlarını ekleyin veya düzenleyin.\r\n    Değişikliklerin yayılması için birkaç saat bekleyin.\r\n\r\nE-posta DNS ile İlgili Güvenlik İpuçları\r\n\r\n    SPF ve DKIM Kaydı Oluşturun: Bu kayıtlar e-posta gönderiminde sahtekarlığı önler.\r\n    DMARC Kullanarak Politika Belirleyin: Yetkisiz gönderimleri karantinaya alın veya engelleyin.\r\n    DNSSEC Entegrasyonu: DNS kayıtlarınızın manipüle edilmesini önlemek için DNSSEC kullanın.\r\n\r\nE-posta DNS kayıtları, güvenilir ve etkili bir e-posta iletişim ağı oluşturmanın temel taşlarıdır. E-posta sunucularınızın doğru çalışmasını sağlamak için DNS kayıtlarınızı düzenli olarak kontrol edin.', 1, 'data/uploads/8583c3bca1.png', '2024-12-07 23:58:04', 2),
(2, 'DNS Yönlendirme (Forwarding) ve Proxy Kullanımı', 'DNS Yönlendirme (Forwarding) ve Proxy Kullanımı\r\n\r\nDNS yönlendirme (forwarding), bir DNS sorgusunun belirli bir DNS sunucusuna aktarılması işlemidir. Bu yöntem, genellikle bir ağdaki DNS çözümleme işlemlerini optimize etmek ve dış DNS sorgularını daha güvenli bir şekilde yönetmek için kullanılır. DNS forwarding, özellikle kurumsal ağlar ve büyük organizasyonlar için önemli avantajlar sunar.\r\nDNS Yönlendirme Nedir?\r\n\r\nDNS yönlendirme, bir ağdaki DNS sunucularının kendi veritabanlarında bulunmayan sorguları başka bir DNS sunucusuna iletmesi işlemidir. Bu süreç, şu şekilde işler:\r\n\r\n    Kullanıcı, bir alan adı sorgusu gönderir.\r\n    Yerel DNS sunucusu sorguyu kontrol eder.\r\n    Kendi veritabanında bir kayıt bulamazsa, sorguyu yapılandırılmış bir yönlendirme sunucusuna iletir.\r\n    Yönlendirme sunucusu sorguyu çözümleyip yanıtlar.\r\n\r\nDNS Proxy ile DNS Yönlendirme Arasındaki Fark\r\n\r\n    DNS Proxy: Kullanıcının DNS sorgularını başka bir DNS sunucusuna geçirirken sorgunun kaynağını gizleyebilir. Genellikle güvenlik amacıyla kullanılır.\r\n    DNS Yönlendirme: Sorguları belirli bir DNS sunucusuna ileterek çözümleme sürecini hızlandırır. Proxy gibi anonimlik sağlamaz, ancak verimliliği artırır.\r\n\r\nDNS Yönlendirme Türleri\r\n\r\n    Statik Yönlendirme: Sorgular, yapılandırılmış belirli bir DNS sunucusuna yönlendirilir.\r\n    Dinamik Yönlendirme: Ağ durumuna veya sorgunun türüne göre farklı DNS sunucularına yönlendirme yapılır.\r\n\r\nDNS Yönlendirmenin Avantajları\r\n\r\n    Hızlı Çözümleme: Önbellekleme ve yönlendirme, sorgu sürelerini azaltır.\r\n    Güvenlik: Güvenilir DNS sunucuları kullanılarak kötü amaçlı sitelere erişim engellenebilir.\r\n    Yük Dengeleme: Yerel DNS sunucularının üzerindeki yük azalır.\r\n\r\nDNS Yönlendirme Nasıl Yapılır?\r\n\r\nDNS yönlendirme yapılandırması, DNS sunucusu yazılımına bağlı olarak değişebilir. Örneğin:\r\n\r\n    Windows Server DNS: İleri yönlendirme (Forwarders) özelliği kullanılır.\r\n    BIND: Forward zone ayarlarıyla yönlendirme yapılandırılır.\r\n\r\nDNS Yönlendirme ile İlgili Güvenlik İpuçları\r\n\r\n    Güvenilir DNS Sunucuları Kullanın: Yönlendirme yapılan DNS sunucularının güvenli olduğundan emin olun.\r\n    DNSSEC Entegrasyonu: Verinin doğruluğunu sağlamak için DNSSEC kullanın.\r\n    Loglama Yapın: DNS yönlendirme trafiğini izleyerek olası sorunları tespit edin.\r\n\r\nDNS yönlendirme, doğru kullanıldığında ağ performansını artıran ve güvenliği geliştiren güçlü bir araçtır.', 1, 'data/uploads/9f0cbae032.png', '2024-12-08 00:20:41', 7),
(3, 'DNS Nedir ve Nasıl Çalışır?', 'DNS Nedir ve Nasıl Çalışır?\r\n\r\nDNS (Domain Name System), internetin telefon rehberi olarak çalışan bir sistemdir. Kullanıcıların hatırlaması kolay alan adlarını (ör. www.google.com) IP adreslerine (ör. 172.217.16.196) çevirir. Bu dönüşüm, bir web sitesine ulaşabilmek için gereklidir.\r\n\r\nDNS\'in temel işleyişi şu adımları içerir:\r\n\r\n    Kullanıcı bir alan adı talebinde bulunur.\r\n    Tarayıcı, DNS sunucularını sorgular.\r\n    DNS sunucusu, doğru IP adresini bulur ve kullanıcıya iletir.\r\n    Tarayıcı, IP adresini kullanarak web sitesine bağlanır.\r\n\r\nDNS Çözümleme Türleri\r\n\r\nDNS çözümleme, talep edilen alan adı ile ilişkilendirilmiş IP adresini bulma işlemidir. Çözümleme türleri şunlardır:\r\n\r\n    İleri DNS Çözümleme: Alan adından IP adresine dönüşüm.\r\n    Ters DNS Çözümleme: IP adresinden alan adı bilgisi elde etme.\r\n    Yerel DNS Çözümleme: Bilgisayarın veya yerel ağın kendi DNS önbelleğini kullanarak hızlı erişim.\r\n\r\nDNS Kayıt Türleri\r\n\r\nDNS kayıtları, bir alan adı hakkında bilgi sağlar. En yaygın DNS kayıt türleri şunlardır:\r\n\r\n    A Kaydı: Alan adını bir IPv4 adresine bağlar.\r\n    AAAA Kaydı: Alan adını bir IPv6 adresine bağlar.\r\n    CNAME Kaydı: Bir alan adını başka bir alan adına yönlendirir.\r\n    MX Kaydı: Alan adının e-posta sunucularını tanımlar.\r\n    TXT Kaydı: Alan adına metin tabanlı açıklama veya doğrulama bilgisi ekler.\r\n\r\nDNS’in Güvenlik Tehditleri\r\n\r\nDNS, internetin temel taşlarından biri olduğu için sık sık saldırılara maruz kalabilir. Yaygın tehditler şunlardır:\r\n\r\n    DNS Spoofing (Zehrleme): Yanıltıcı DNS kayıtları ile kullanıcıları sahte sitelere yönlendirme.\r\n    DDoS Saldırıları: DNS sunucularını aşırı yükleyerek çökertme girişimi.\r\n    Cache Poisoning: DNS önbelleğine zararlı bilgiler ekleme.\r\n\r\nDNS güvenliğini sağlamak için DNSSEC (DNS Security Extensions) gibi teknolojiler kullanılır.\r\nDNS Sunucuları ve Türleri\r\n\r\nDNS sunucuları, farklı işlevlere göre ayrılır:\r\n\r\n    Root DNS Sunucuları: En üst düzeyde çalışır ve diğer DNS sunucularına yönlendirme yapar.\r\n    Yetkili DNS Sunucuları: Bir alan adının IP adresini barındırır ve yanıtlar.\r\n    Önbellek DNS Sunucuları: Daha önce yapılan sorguları önbelleğe alarak hızlandırma sağlar.\r\n\r\nPopüler DNS sağlayıcıları arasında Google Public DNS, Cloudflare DNS, ve OpenDNS bulunur.', 1, 'data/uploads/8bb66d9ee5.png', '2024-12-08 09:26:20', 4),
(4, 'DNS Kayıt Oluşturucu ile Kolay ve Güvenli DNS Yönetimi', '# DNS Kayıt Oluşturucu ile Kolay ve Güvenli DNS Yönetimi\r\n# \r\nDNS yönetimi, özellikle e-posta güvenliği ve doğru yapılandırmalar için kritik bir öneme sahiptir. DNS Kayıt Oluşturucu, kullanıcıların DNS kayıtlarını kolayca oluşturabilmesi ve Cloudflare gibi popüler platformlara hızlıca entegre edebilmesi için tasarlanmış bir araçtır. Bu yazıda, DNS Kayıt Oluşturucu\'nun temel özellikleri ve sunduğu avantajları inceleyeceğiz.\r\n**DNS Kayıt Oluşturucu Nedir?\r\n**\r\nDNS Kayıt Oluşturucu, kullanıcıların aşağıdaki kayıt türlerini hızlı ve kolay bir şekilde oluşturmasını sağlar:\r\n\r\n    A Kayıtları: Alan adını bir IP adresine yönlendirmek için kullanılır.\r\n    MX Kayıtları: E-posta trafiğinin doğru sunuculara yönlendirilmesini sağlar.\r\n    SPF Kayıtları: Gönderilen e-postaların doğrulanmasını ve sahtecilik girişimlerinin önlenmesini sağlar.\r\n    DKIM ve DMARC Kayıtları: E-posta güvenliğini artıran dijital imza ve kimlik doğrulama kayıtları.\r\n    CNAME ve SRV Kayıtları: Alan adı yönlendirme ve özel hizmet ayarlarını kolaylaştırır.\r\n    PTR ve BIMI Kayıtları: E-posta güvenilirliğini ve marka görünürlüğünü artırır.\r\n\r\n**Öne Çıkan Özellikler\r\n**\r\n    Kullanıcı Dostu Arayüz\r\n    DNS Kayıt Oluşturucu, kullanıcı dostu bir tasarıma sahiptir. Her kayıt türü için açıklamalar ve örnek alanlar sunarak kullanıcıların doğru yapılandırmalar yapmasını sağlar.\r\n\r\n    Cloudflare Uyumlu Çıktılar\r\n    Araç, oluşturulan DNS kayıtlarını Cloudflare gibi popüler DNS sağlayıcılarına kolayca aktarılabilir formatta sunar. Bu sayede manuel ayarlarla vakit kaybetmeden DNS yapılandırmanızı tamamlayabilirsiniz.\r\n\r\n    Güçlü Güvenlik Desteği\r\n    SPF, DKIM ve DMARC gibi güvenlik odaklı kayıtlarla e-posta iletişiminizin güvenilirliğini artırabilirsiniz.\r\n\r\n    Esnek ve Özelleştirilebilir Seçenekler\r\n    Kayıt türleri arasında seçim yapabilir, yalnızca ihtiyacınız olan kayıtları oluşturabilirsiniz. Her kayıt türü için detaylı ayarlar sunularak özelleştirme imkanları sağlanır.\r\n\r\n**Kullanım Adımları\r\n**\r\n    Alan Adı ve IP Girişi\r\n    İlgili alan adını ve IP adresini girerek yapılandırmaya başlayabilirsiniz.\r\n\r\n    Gerekli Kayıtları Seçin\r\n    A, MX, SPF, DKIM gibi ihtiyacınız olan kayıt türlerini seçerek formdaki gerekli bilgileri doldurun.\r\n\r\n    DNS Kayıtlarını Oluşturun\r\n    Formu doldurduktan sonra oluşturulan kayıtları görebilir ve indirerek kullanabilirsiniz.\r\n\r\n    Cloudflare veya Başka DNS Sağlayıcılarına Entegre Edin\r\n    İndirilen DNS kayıtlarını doğrudan Cloudflare veya diğer DNS yönetim panellerine yükleyerek hemen kullanmaya başlayabilirsiniz.\r\n\r\n**Kullanıcıya Sunulan Ekstra Avantajlar\r\n**\r\n    Kopyala ve Düzenle: Oluşturulan kayıtlar üzerinde kolay düzenleme ve kopyalama imkanı.\r\n    TXT Formatında İndirme: Cloudflare uyumlu TXT dosyası oluşturma ve indirme seçeneği.\r\n    Bilgilendirici İpuçları ve Öneriler: Kullanıcıların doğru ayar yapmasını kolaylaştırmak için açıklamalar ve öneriler.\r\n\r\n**DNS Kayıt Oluşturucu\'yu Neden Kullanmalısınız?\r\n**\r\n    Hızlı ve Etkili: DNS kayıtlarını manuel olarak yazmak yerine otomatik oluşturma.\r\n    Güvenli: E-posta güvenliği için en iyi uygulamaları destekler.\r\n    Kolay Entegrasyon: Popüler DNS sağlayıcılarıyla tam uyumluluk.\r\n\r\nDNS Kayıt Oluşturucu, hem bireysel kullanıcılar hem de profesyonel IT yöneticileri için tasarlanmış güçlü ve pratik bir araçtır. DNS kayıtlarınıza kolayca hakim olun ve e-posta güvenliğinizi artırın!', 2, 'data/uploads/b938514203.png', '2024-12-08 19:40:23', 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'Default Site Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `site_name`) VALUES
(1, 'site_name', 'M-DNS Bog', 'Default Site Name'),
(2, 'site_desc', 'A Profesyonel Dns blog', 'Default Site Name'),
(3, 'site_keywords', 'blog, personal, travel, technology', 'Default Site Name'),
(4, 'site_url', 'https://m-dns.org/blog', 'Default Site Name'),
(5, 'site_logo', '', 'Default Site Name'),
(6, 'footer_brand', 'M-DNS 2024 - All Rights Reserved', 'Default Site Name'),
(7, 'social_facebook', 'https://m-dns.org', 'Default Site Name'),
(8, 'social_twitter', 'https://m-dns.org', 'Default Site Name'),
(9, 'social_instagram', 'https://m-dns.org', 'Default Site Name'),
(10, 'homepage_post_count', '10', 'Default Site Name'),
(11, 'homepage_excluded_categories', '', 'Default Site Name'),
(12, 'homepage_sticky_post', '', 'Default Site Name');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Ali', '$2y$12$W6Sw8Ydz.ZEqnPE/bPgZcu9K9MbjbkyAzNZ4HIBBbqnshL8Vkj1ZK');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
