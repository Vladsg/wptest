<section class="contacts">
    <h2 class="contacts__title">Contact Us</h2>
    <form action=''>
        <input type="hidden" name="action" value="formSend">
        <input type='text' name='name' placeholder='Name'>
        <input type='email' name='email' placeholder='Email' required>
        <textarea name='message' placeholder='Message' required></textarea>
        <button type="submit">Send</button>
    </form>
</section>
</div>
<?php
wp_footer();
?>
</body>
</html>