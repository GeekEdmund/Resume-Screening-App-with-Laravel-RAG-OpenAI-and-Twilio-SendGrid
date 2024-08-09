<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application - OldFactor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e5e5e5; /* Light grey background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('background-pattern.png'); /* Add a subtle background pattern */
            background-size: cover;
        }
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .form-container h1 {
            color: #0d122b;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-container p {
            color: #555;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #F22F46;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group input[type="submit"]:hover {
            background-color: #c11e34;
        }
        .additional-content {
            margin-top: 20px;
            text-align: left;
        }
        .additional-content h2 {
            color: #0d122b;
            margin-bottom: 10px;
        }
        .additional-content ul {
            color: #555;
            list-style-type: disc;
            padding-left: 20px;
        }
        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .message-success {
            background-color: #d4edda;
            color: #155724;
        }
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if(session('success')): ?>
            <div class="message message-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php elseif(session('error')): ?>
            <div class="message message-error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <h1>Apply for Machine Learning Engineer Position at OldFactor</h1>
        <p>Join our dynamic team and help us build the future of communications. We are looking for innovative and driven individuals to contribute to our success.</p>
        <form action="<?php echo e(route('upload.resume')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="resume">Upload Resume:</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit Application">
            </div>
        </form>
        <div class="additional-content">
            <h2>Why Join OldFactor?</h2>
            <ul>
                <li>Work with cutting-edge technology and tools.</li>
                <li>Collaborate with a diverse and talented team.</li>
                <li>Enjoy a flexible and supportive work environment.</li>
                <li>Contribute to impactful projects that shape the future.</li>
            </ul>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\lizpa\OneDrive\Desktop\resume-screening\resources\views/upload.blade.php ENDPATH**/ ?>