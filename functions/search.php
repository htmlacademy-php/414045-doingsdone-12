<?php

function search_task($user_id, $search_string): array|null
{
    $search_string = trim($search_string) ?? null;

    return $search_string ? get_looking_for_task($user_id, $search_string)
        : null;
}