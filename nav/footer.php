<footer>
    <p>The Proving Grounds - Henrik Andersen 2023 - (c) - Wildly Swinging</p>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <form method="post" action="/../functions/endSession.php">
            <button type="submit" name="endSession">Log Out</button>
        </form>
    <?php endif; ?>
</footer>
<script src="/../styles/script.js"></script>
</body>

</html>