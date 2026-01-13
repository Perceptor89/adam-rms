<?php
require_once __DIR__ . '/../apiHeadSecure.php';

$icons = json_decode(file_get_contents(__DIR__ . '/icons.json'), true);

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $icons = array_filter($icons, function($icon) {
        $search = strtolower($_POST['search']);
        if (strpos(strtolower($icon['code']), $search) !== false) return true;
        if (strpos(strtolower($icon['label']), $search) !== false) return true;
        foreach ($icon['keywords'] as $keyword) {
            if (strpos(strtolower($keyword), $search) !== false) return true;
        }
        return false;
    });
    $icons = array_values($icons);
}

if (isset($_POST['all']) && $_POST['all'] == '1') {
    // Return all icons for palette view
} else if (isset($_POST['search']) && !empty($_POST['search'])) {
    $icons = array_slice($icons, 0, 50);
} else {
    $icons = array_slice($icons, 0, 100);
}

finish(true, null, $icons);

/**
 *  @OA\Post(
 *      path="/icons/getIcons.php",
 *      summary="List Icons",
 *      description="Get a list of the first 20 available icons",
 *      operationId="getIcons",
 *      tags={"icons"},
 *       @OA\Response(
 *          response="200",
 *          description="Success",
 *          @OA\MediaType(
 *             mediaType="application/json", 
 *             @OA\Schema(ref="#/components/schemas/SimpleResponse"),
 *         ),
 *      ),
 *      @OA\Parameter(
 *          name="search",
 *          in="query",
 *          description="Icon search term",
 *          required="false",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *      ),
 *  )
 */