<?php
// tasks file
$tasksFile = 'tasks.json';

// Load tasks
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true);
    if (!is_array($tasks)) {
        $tasks = [];
    }
} else {
    $tasks = [];
}

// Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if ($task !== '') {
        $tasks[] = ['name' => $task, 'done' => false];
        file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Toggle Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle'])) {
    $index = intval($_POST['toggle']);
    if (isset($tasks[$index])) {
        $tasks[$index]['done'] = !$tasks[$index]['done'];
        file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Delete Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $index = intval($_POST['delete']);
    if (isset($tasks[$index])) {
        array_splice($tasks, $index, 1);
        file_put_contents($tasksFile, json_encode($tasks, JSON_PRETTY_PRINT));
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
    <style>
    body {
        margin-top: 20px;
    }

    .task-card {
        border: 1px solid #ececec;
        padding: 20px;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .task-done {
        text-decoration: line-through;
        color: black;
    }

    .task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    ul {
        padding-left: 0;
    }

    button {
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="task-card">
            <h1>To-Do App</h1>

            <!-- Add Task Form -->
            <form method="POST">
                <div class="row">
                    <div class="column column-75">
                        <input type="text" name="task" placeholder="Enter a new task" required>
                    </div>
                    <div class="column column-25">
                        <button type="submit" class="button-primary">Add Task</button>
                    </div>
                </div>
            </form>

            <!-- Task List -->
            <h2>Task List</h2>
            <ul style="list-style: none;">
                <?php if (empty($tasks)) : ?>
                <li>No tasks yet. Add one above!</li>
                <?php else : ?>
                <?php foreach ($tasks as $index => $task) : ?>
                <li class="task-item">
                    <form method="POST" style="flex-grow: 1;">
                        <input type="hidden" name="toggle" value="<?php echo $index; ?>">
                        <button type="submit" style="border: none; background: none; text-align: left; width: 100%;">
                            <span class="<?php echo $task['done'] ? 'task-done' : ''; ?>">
                                <?php echo htmlspecialchars($task['name']); ?>
                            </span>
                        </button>
                    </form>
                    <form method="POST">
                        <input type="hidden" name="delete" value="<?php echo $index; ?>">
                        <button type="submit" class="button button-outline">Delete</button>
                    </form>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>

</html>