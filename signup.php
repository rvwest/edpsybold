<!-- file: signup.php -->
<div id="signup-slice">
    <div class="signup-container grid12">
        <div class="signup-content span10">
            <div class="message">
                <h2>Sign up for updates</h2>
                <p>Find out about new blogs, jobs, features and events by email</p>
                <p>We will never share your email with anyone else.</p>
            </div>

            <form action="https://edpsy.us1.list-manage.com/subscribe/post" method="POST">

                <input type="hidden" name="u" value="a213811bc69b5636c5103c46a">
                <input type="hidden" name="id" value="cf7c127239">

                <!-- people should not fill these in and expect good things -->
                <div class="field-shift" aria-label="Please leave the following three fields empty" aria-hidden="true">
                    <label for="b_name">Name: </label>
                    <input type="text" name="b_name" tabindex="-1" value="" placeholder="Freddie" id="b_name">

                    <label for="b_email">Email: </label>
                    <input type="email" name="b_email" tabindex="-1" value="" placeholder="youremail@gmail.com"
                        id="b_email">

                    <label for="b_comment">Comment: </label>
                    <textarea name="b_comment" tabindex="-1" placeholder="Please comment" id="b_comment"></textarea>
                </div>
                <input type="text" id="MERGE1" name="MERGE1" placeholder="forename" required>
                <input type="text" id="MERGE2" name="MERGE2" placeholder="surname" required>

                <input type="email" id="MERGE0" name="MERGE0" placeholder="email" required>
                <br>

                <button type="submit" class="edp-button-solid" value="Subscribe">Subscribe</button>
            </form>
            <div class="mc4wp-response"></div>
        </div>
    </div>
</div>
<!-- file end: signup.php -->