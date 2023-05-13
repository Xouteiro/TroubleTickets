
<?php
function output_login(Session $session)
{ ?>
  <div class="account">
    <h2>Log In</h2>
    <form action="../actions/action_login.php" method="post">
      <div class='full-input'>
        <label for="email">Email</label>
        <input type="email" name="email" id='email' placeholder="youremail@mail.com">
      </div>
      <div class='full-input'>
        <label for="password">Password</label>
        <input type="password" name="password" id='password' placeholder="pAsSw0rd">
      </div>
      <button type="submit" name="submit" class="login">Enter</button>
    </form>
    <p>Don't have an account?<a href="register.php">Sign Up</a></p>
  </div>

<?php } ?>

<?php
function output_register(Session $session)
{ ?>
  <div class="account">
    <h2>Create new account</h2>
    <form id="register" action="../actions/action_register.php" method="post">
      <div class='full-input'>
        <label for="username">Username</label>
        <input type="text" name="username" id='username' placeholder="User_name01">
      </div>
      <div class='full-input'>
        <label for="email">Email</label>
        <input type="email" name="email" id='email' placeholder="youremail@mail.com">
      </div>
      <div class='full-input'>
        <label for="password">Password</label>
        <input type="password" name="password" id='password' placeholder="pAsSw0rd">
      </div>
      <div class='full-input'>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id='confirm_password' placeholder="pAsSw0rd">
      </div>
      <button type="submit" name="submit" class="login">Create account</button>
    </form>

    <p>Already have an account?<a href="login.php">Log in</a></p>
  </div>
  <?php
}