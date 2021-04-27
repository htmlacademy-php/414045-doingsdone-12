<?php

function search_task($user_id): array|null
{
    $searchString = trim($_GET['search']) ?? null;

    return $searchString ? get_looking_for_task($user_id, $searchString) : null;
}