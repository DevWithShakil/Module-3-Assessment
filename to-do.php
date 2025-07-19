<?php
// Simple Terminal Based ToDo App

$filename = "todo.txt";

if (!file_exists($filename)) {
    file_put_contents($filename, "");
}

echo "Simple ToDo App (Terminal Based)\n";
echo "===============================\n";
echo "1. View Tasks\n";
echo "2. Add Task\n";
echo "3. Remove Task\n";
echo "4. Exit\n";
echo "Enter your choice: ";

$choice = trim(fgets(STDIN));

switch ($choice) {
    case 1:
        viewTasks($filename);
        break;
    case 2:
        addTask($filename);
        break;
    case 3:
        removeTask($filename);
        break;
    case 4:
        echo "Goodbye!\n";
        exit;
    default:
        echo "Invalid choice. Try again.\n";
        break;
}

function viewTasks($filename) {
    $tasks = file($filename, FILE_IGNORE_NEW_LINES);
    if (count($tasks) === 0) {
        echo "No tasks found.\n";
    } else {
        echo "Your Tasks:\n";
        foreach ($tasks as $index => $task) {
            echo ($index + 1) . ". " . $task . "\n";
        }
    }
}

function addTask($filename) {
    echo "Enter new task: ";
    $task = trim(fgets(STDIN));
    if (!empty($task)) {
        file_put_contents($filename, $task . PHP_EOL, FILE_APPEND);
        echo "Task added successfully.\n";
    } else {
        echo "Empty task not added.\n";
    }
}

function removeTask($filename) {
    $tasks = file($filename, FILE_IGNORE_NEW_LINES);
    if (count($tasks) === 0) {
        echo "No tasks to remove.\n";
        return;
    }

    echo "Enter task number to remove: ";
    $num = trim(fgets(STDIN));

    if (is_numeric($num) && $num >= 1 && $num <= count($tasks)) {
        unset($tasks[$num - 1]);
        file_put_contents($filename, implode(PHP_EOL, $tasks) . PHP_EOL);
        echo "Task removed successfully.\n";
    } else {
        echo "Invalid task number.\n";
    }
}
?>