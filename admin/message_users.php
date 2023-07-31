<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .message-row {
      cursor: pointer;
    }
    .message-row:hover {
      background-color: #f1f1f1;
    }
    .selected-message {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Admin Panel - Messages</h2>
  <div class="row">
    <div class="col-md-6">
      <h4>Messages</h4>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Subject</th>
          </tr>
        </thead>
        <tbody id="message-table">
          <!-- Populate messages dynamically with JavaScript -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <h4>Selected Message</h4>
      <form id="message-form">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" id="username" readonly>
        </div>
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" class="form-control" id="subject" readonly>
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea class="form-control" id="message" rows="5" readonly></textarea>
        </div>
        <div class="form-group">
          <label for="admin_message">Response:</label>
          <textarea class="form-control" id="admin_message" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Response</button>
      </form>
    </div>
  </div>
</div>
<footer class="footer w-100">
    <div class="container-fluid">
      <div class="card footer-card">
        <div class="row">
          <div class="col-lg-6">
            <ul class="footer-links">
              <li><a href="../index.php">Home</a></li>
              <li><a href="#">Browse Cars</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="footer-social-icons">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="footer-text mb-2">© 2023 CarVentory. All rights reserved.</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  // Fetch messages and populate the table
  $.ajax({
    url: '../configurations/get_messages.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      var messageTable = $('#message-table');
      data.forEach(function(message) {
        var row = '<tr class="message-row" data-id="' + message.id + '">';
        row += '<td>' + message.id + '</td>';
        row += '<td>' + message.username + '</td>';
        row += '<td>' + message.subject + '</td>';
        row += '</tr>';
        messageTable.append(row);
      });

      // Handle row click event
      $('.message-row').click(function() {
        $('.message-row').removeClass('selected-message');
        $(this).addClass('selected-message');

        // Retrieve message details using the selected ID
        var messageId = $(this).data('id');
        $.ajax({
          url: '../configurations/get_message.php',
          method: 'GET',
          dataType: 'json',
          data: { id: messageId },
          success: function(data) {
            $('#username').val(data.username);
            $('#subject').val(data.subject);
            $('#message').val(data.message);
          }
        });
      });
    }
  });

  $('#message-form').submit(function(e) {
    e.preventDefault();
    var messageId = $('.selected-message').data('id');
    var response = $('#admin_message').val();

    $.ajax({
      url: '../configurations/send_response.php',
      method: 'POST',
      data: { id: messageId, admin_message: response }, // Use 'id' as the key for the message ID
      success: function(data) {
        alert('Response sent successfully.');
        // Clear the response textarea
        $('#admin_message').val('');
      }
    });
  });
});
</script>

</body>
</html>
