
<?php
function output_profile_info(User $user)
{ ?>
  <h2>Profile</h2>
  <button onclick="openProfileTab(event, 'profile-edit')">
    <i class="material-symbols-rounded">edit</i>
  </button>
  <hr>
  <i class="material-symbols-rounded">person</i>
  <p><?php echo $user->username ?></p>
  <br>
  <p>Name</p>
  <br>
  <i class="material-symbols-rounded">mail</i>
  <p><?php echo $user->email ?></p>
  <br>
  <p>Email</p>
  <br>
  <?php if ($user->phone != null) {?>
  <i class="material-symbols-rounded">call</i>
  <p><?php echo $user->phone ?></p>
  <br>
  <p>Phone Number</p>
  <br>
  <?php } ?>
  <?php if ($user->address != null) {?>
  <i class="material-symbols-rounded">home_pin</i>
  <p><?php echo $user->address ?></p>
  <br>
  <p>Address</p>
  <?php } ?>
  <?php if ($user->city != null and $user->country != null) { ?>
    <br>
    <i class="material-symbols-rounded">map</i>
    <p><?= $user->city . ", " . $user->country; ?></p>
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
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="submit" class="login">Enter</button>
    </form>
    <a href="register.php">Create an account</a>
  </div>

<?php } ?>

<?php
function output_register(Session $session)
{ ?>
  <div class="account">
    <h2>Register</h2>
    <form id="register" action="../actions/action_register.php" method="post">
      <input type="text" name="username" placeholder="Username">
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirm_password" placeholder="Confirm Password">
      <button type="submit" name="submit" class="login">Create account</button>
    </form>

    <a href="login.php">I have an account</a>
  </div>
<?php
}