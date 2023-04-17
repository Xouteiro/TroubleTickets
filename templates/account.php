<?php
function output_profile_info(User $user)
{ ?>
  <h2>Profile</h2>
  <button onclick="openProfileTab(event, 'profile-edit')">
    <i class="material-symbols-rounded">edit</i>
  </button>
  <hr>
  <i class="material-symbols-rounded">person</i>
  <p>
    <?php echo $user->username ?>
  </p>
  <br>
  <p>Name</p>
  <br>
  <i class="material-symbols-rounded">mail</i>
  <p>
    <?php echo $user->email ?>
  </p>
  <br>
  <p>Email</p>
  <br>
  <?php if ($user->phone != null) { ?>
    <i class="material-symbols-rounded">call</i>
    <p>
      <?php echo $user->phone ?>
    </p>
    <br>
    <p>Phone Number</p>
    <br>
  <?php } ?>
  <?php if ($user->address != null) { ?>
    <i class="material-symbols-rounded">home_pin</i>
    <p>
      <?php echo $user->address ?>
    </p>
    <br>
    <p>Address</p>
  <?php } ?>
  <?php if ($user->city != null and $user->country != null) { ?>
    <br>
    <i class="material-symbols-rounded">map</i>
    <p>
      <?= $user->city . ", " . $user->country; ?>
    </p>
    <br>
    <p>City</p>
  <?php } ?>
  <br>
<?php } ?>





<?php
function output_login(Session $session)
{ ?>
  <div class="account">
    <h2>Log In</h2>
    <form action="../actions/action_login.php" method="post">
      <div class='full-input'>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="youremail@mail.com">
      </div>
      <div class='full-input'>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="pAsSw0rd">
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
        <input type="text" name="username" placeholder="User_name01">
      </div>
      <div class='full-input'>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="youremail@mail.com">
      </div>
      <div class='full-input'>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="pAsSw0rd">
      </div>
      <div class='full-input'>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="pAsSw0rd">
      </div>
      <button type="submit" name="submit" class="login">Create account</button>
    </form>

    <p>Already have an account?<a href="login.php">Log in</a></p>
  </div>
  <?php
}