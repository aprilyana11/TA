<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C1E0A2FE;
        }

        .btn-primary {
            background-color: #527321FE;
            border-color: #527321FE;
        }

        .btn-primary:hover {
            background-color: #527321FE;
            border-color: #527321FE;
        }

        .list-group-item-action.active {
            background-color: #527321FE;
            border-color: #527321FE;
        }

        .list-group-item-action.active:hover {
            background-color: #527321FE;
            border-color: #527321FE;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-button a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            background-color: #527321FE;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .back-button a:hover {
            background-color: #435D21;
        }

        .back-button a::before {
            content: '←';
            margin-right: 1px;
        }

        .container {
            margin-top: 80px;
            /* Adjust this value to lower the white box */
        }
    </style>
</head>

<body>
    <div class="back-button">
        <a href="/dashboard"></a>
    </div>

    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Profile Settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="text-right mt-3 mb-3">
                        <!-- Buttons if needed -->
                    </div>
                    <div class="tab-content">
                        <!-- General Information Tab -->
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <p>{{ $username }}</p>
                                </div>
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Berat Badan</label>
                                        <div style="display: flex; align-items: center;">
                                            <input type="text" class="form-control" name="weight" value="{{ $weight }}" id="weight" style="width: auto; display: inline;">
                                            <p style="margin-left: 5px; margin-bottom: 0;">kg</p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <form action="{{ route('profile.passchange') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
            </div>
        </div>
    </div>
</body>

</html>