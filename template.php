<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * GA Omega theme.
 */

/**
 * Implements hook_form_alter().
 * removes advanced search fields from the form on the search results page
 */
function ga_omega_form_alter(&$form, &$form_state, $form_id) {
  // Selecting the form based upon the form id.
  switch ($form_id) {
    case 'search_form':
      unset($form['advanced']);
    break;
  }
}

/**
 * Implements hook_query_alter().
 * removes content types defined in the excluded_content_types array from search results
 */
function ga_omega_query_alter(&$query) {
  $is_search = FALSE;

    $excluded_content_types = array(
      'product',
      'billboard',
      'news',
      'testimonial',
      'video_tips',
      'webform',
    );
  foreach ($query->getTables() as $table) {
    if ($table['table'] == 'search_index') {
      $is_search = TRUE;
    }
  }
  if ($is_search) {
    foreach ($excluded_content_types as $content_type) {
      $query->condition('n.type', $content_type, '<>');
    }
  }
}