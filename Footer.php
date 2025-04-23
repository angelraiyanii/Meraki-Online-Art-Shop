<style>
    .footer {
        background-color: rgba(165, 165, 165, 0.7);;
        width: auto;
        margin-top: 20px;
        margin-left: 5%;
        margin-right: 5%;

        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .footer-sections {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .footer-section {
        flex: 1;
        margin-right: 20px;
        margin-left: 20px;
    }

    .footer-section h4 {
        font-size: 16px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        text-decoration: none;
        color: #ffffff;
        font-size: 14px;
    }

    .footer-section ul li a:hover {
        text-decoration: underline;
    }

    .footer-section.newsletter p {
        font-size: 14px;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .footer-section.newsletter form {
        /* display: flex; */
    }

    .footer-section.newsletter input {
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        flex: 1;
    }

    .footer-section.newsletter button {
        padding: 8px 16px;
        border: none;
        background-color: #007bff;
        color: #ffffff;
        border-radius: 4px;
        margin-left: 10px;
        cursor: pointer;
    }

    .footer-section.newsletter button:hover {
        background-color: #0056b3;
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #dee2e6;
        padding-top: 20px;
    }

    .footer-bottom p {
        margin: 0;
        color: #ffffff;
        font-size: 14px;
    }

    .social-icons a {
        margin-left: 10px;
    }

    .social-icons img {
        width: 24px;
        height: 24px;
    }
</style>
<footer class="row footer mb-5">
    <div class="row">
        <div class="footer-sections">
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2024 Meraki, Inc. All rights reserved.</p>
        <div class="social-icons">
            <a href="#"><img src="Img/twitter.png" alt="Twitter"></a>
            <a href="#"><img src="Img/instagram.png" alt="Instagram"></a>
            <a href="#"><img src="Img/facebook.png" alt="Facebook"></a>
        </div>
    </div>
</footer>
</body>

</html>