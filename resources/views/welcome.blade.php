<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Todo List</title>
    <!-- Bootstrap Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <style>
        .completed {
            text-decoration: line-through;
            color: gray;
        }
        .title {
            font-weight: bold;
            color: blue;
        }
        .delete-icon {
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h3 class="title">Todo List</h3>
        <div class="input-group">
            <input type="text" id="taskInput" class="form-control" placeholder="Enter a new task">
            <span class="input-group-btn">
                <button class="btn btn-default" id="addTaskButton" type="button">Enter</button>
            </span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tasks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskList">
            </tbody>
        </table>
        <button class="btn btn-primary" id="showAllTasksButton" type="button">Show All Tasks</button>
    </div>
</div>

<script>
$(document).ready(function() {
    let tasks = [];
    let serialNumber = 0;

    $('#addTaskButton').click(function() {
        let taskInput = $('#taskInput').val().trim();
        if (taskInput === "") {
            alert("Task cannot be empty!");
            return;
        }
        if (tasks.includes(taskInput)) {
            alert("Task already exists!");
            return;
        }
        tasks.push(taskInput);
        addTask(taskInput);
        $('#taskInput').val('');
    });

    $('#taskInput').keypress(function(e) {
        if (e.which === 13) {
            $('#addTaskButton').click();
        }
    });

    function addTask(task) {
        serialNumber++;
        let taskItem = $('<tr></tr>');
        let checkbox = $('<input type="checkbox" class="pull-left">');
        let deleteIcon = $('<span class="delete-icon pull-right">X</span>');

        deleteIcon.click(function() {
            if (confirm("Are you sure to delete this task?")) {
                $(this).closest('tr').remove();
                tasks = tasks.filter(t => t !== task);
                updateSerialNumbers();
            }
        });

        checkbox.change(function() {
            let isChecked = $(this).prop('checked');
            let taskRow = $(this).closest('tr');
            if (isChecked) {
                taskRow.addClass('completed');
                taskRow.find('td:eq(2)').text('Done');
            } else {
                taskRow.removeClass('completed');
                taskRow.find('td:eq(2)').text('');
            }
        });

        taskItem.append('<td>' + serialNumber + '</td>');
        taskItem.append('<td>' + task + '</td>');
        taskItem.append('<td></td>');
        taskItem.append($('<td></td>').append(checkbox).append('&nbsp;').append(deleteIcon));
        $('#taskList').append(taskItem);
    }

    function updateSerialNumbers() {
        $('#taskList tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }

    $('#showAllTasksButton').click(function() {
        $('#taskList').children().each(function() {
            $(this).show();
        });
    });
});
</script>
</body>
</html>
