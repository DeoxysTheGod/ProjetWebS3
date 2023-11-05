<?php
namespace rtff\views;

/**
 * Class CreateUserView
 * Responsible for rendering the user creation view.
 */
class CreateUserView
{
    /**
     * Render the user creation view.
     */
    public function show(): void
    {
        // Start buffering output
        ob_start();
        ?>
        <!-- Link to the stylesheet for user creation -->
        <link rel="stylesheet" href="/assets/styles/create-user.css">

        <!-- User creation form -->
        <div class="content">
            <form method="post" action="/authentication/create-user" enctype="multipart/form-data">
                <!-- Email input field -->
                <div>
                    <label for="user_id">Email Address</label><br>
                    <input type="email" name="user_id" id="user_id" required>
                </div>

                <!-- Password input field -->
                <div>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" required>
                </div>

                <!-- Display name input field -->
                <div>
                    <label for="display_name">Display Name</label><br>
                    <input type="text" name="display_name" id="display_name" required>
                </div>

                <!-- Profile image upload field -->
                <div>
                    <label for="profileImage">Profile Image</label><br>
                    <input type="file" name="profileImage" accept="image/*" required>
                </div>

                <!-- Submit button -->
                <div>
                    <input type="submit" value="Create Account">
                </div>
            </form>
        </div>
        <?php
        // Render layout with the buffered content
        (new Layout('Create User', ob_get_clean()))->show();
    }
}
