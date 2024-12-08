M-DNS Blog
==========

An open-source, user-friendly, and dynamic blog system.

Features
--------

*   **Dynamic content management**: Easily manage blog posts and categories.
*   **Markdown support**: Simple formatting for your posts.
*   **View counter**: Track the number of views for each post.
*   **Modern and mobile-responsive design**: Built with Bootstrap 5.
*   **GitHub-style interface**: Clean and professional look.
*   **Visitor counter styled like GitHub contributions.**
*   **Plug-and-play usage**: Simple to set up and use.

Installation
------------

To set up this project in your environment, follow these steps:

1.  **Clone the Repository:**
    
    ```bash
    git clone https://github.com/username/mdns-blog.git
    cd mdns-blog
    ```
    
2.  **Set Up the Database:**
    
    *   Create a database.
    *   Import the `blog.sql` file included with the project using this command:
    
    ```bash
    mysql -u your_username -p blogdns < blogdns.sql
    ```
    
3.  **Configure the Database Connection:**
    
    Open the `includes/db.php` file and update the following lines:
    
    ```php
    $host = 'localhost';
    $dbname = 'blogdns';
    $username = 'your_username';
    $password = 'your_password';
    ```
    
4.  **Configure the Web Server:**
    
    Set the project as the root directory of your local server and run it.

    This system is simple and minimal. If you encounter any issues, please don't hesitate to ask. You're awesome!

Screenshots
-----------

Below are some screenshots of the project:

### Homepage
![Homepage](https://m-dns.org/media/blog1.png)

### Blog Post View
![Blog Post View](https://m-dns.org/media/blog2.png)

### Admin Panel - Post Management
![Admin Panel - Post Management](https://m-dns.org/media/blog3.png)

### Admin Panel - Category Management
![Admin Panel - Category Management](https://m-dns.org/media/blog4.png)

### Blog Settings
![Blog Settings](https://m-dns.org/media/blog5.png)

Contributing
------------

We welcome contributions to enhance the project! Follow these steps to contribute:

1.  Fork this repository.
2.  Create a new branch: `git checkout -b feature/your-feature`
3.  Make your changes and commit: `git commit -m "Add your feature"`
4.  Submit a pull request: `git push origin feature/your-feature`

License
-------

This project is licensed under the **MIT License**. For more details, refer to the `LICENSE` file.

© 2024 M-DNS Blog. All rights reserved.
