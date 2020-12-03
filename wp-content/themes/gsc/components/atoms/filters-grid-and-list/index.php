<?php

 $defaults = [
   "content" => [
    "id" => "",
    "class" => ""
  ]
];
gsc_define("filters-grid-and-list", $defaults, function ($data) {

  $content = "
    <ul class='filters-view' {$data['content']['id']}>
      <li class='filters-view__item {$data['content']['class']}'>
        <button data-toggle='grid' type='button' class='filters-view__btn btn--toggle js-filter-view active' aria-pressed='true'>
          <span class='scrn-rdr-txt'>Show grid view</span>
          <span class='filters-view__ico ico ico--grid'>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewbox='0 0 24 24' aria-hidden='true'>
              <title>Gird view option</title>
              <g transform='translate(-351.005 -5171)'>
                <path class='ico__path' d='M351.755,5173.25a1.5,1.5,0,0,1,1.5-1.5h6a1.5,1.5,0,0,1,1.5,1.5v6a1.5,1.5,0,0,1-1.5,1.5h-6a1.5,1.5,0,0,1-1.5-1.5Z' />
                <path class='ico__path' d='M351.755,5186.75a1.5,1.5,0,0,1,1.5-1.5h6a1.5,1.5,0,0,1,1.5,1.5v6a1.5,1.5,0,0,1-1.5,1.5h-6a1.5,1.5,0,0,1-1.5-1.5Z' />
                <path class='ico__path' d='M365.255,5173.25a1.5,1.5,0,0,1,1.5-1.5h6a1.5,1.5,0,0,1,1.5,1.5v6a1.5,1.5,0,0,1-1.5,1.5h-6a1.5,1.5,0,0,1-1.5-1.5Z' />
                <path class='ico__path' d='M365.255,5186.75a1.5,1.5,0,0,1,1.5-1.5h6a1.5,1.5,0,0,1,1.5,1.5v6a1.5,1.5,0,0,1-1.5,1.5h-6a1.5,1.5,0,0,1-1.5-1.5Z' />
              </g>
            </svg>
          </span>
        </button>
      </li>

      <li class='filters-view__item {$data['content']['class']}'>
        <button data-toggle='list' type='button' class='filters-view__btn btn--toggle js-filter-view' aria-pressed='false'>
          <span class='scrn-rdr-txt'>Show list view</span>
          <span class='filters-view__ico ico ico--list'>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewbox='0 0 24 24' aria-hidden='true'>
              <title>List view option</title>
              <g transform='translate(-255.005 -4827)'>
                <path class='ico__path' d='M263.255,4830.75h15' />
                <path class='ico__path' d='M263.255,4839.75h15' />
                <path class='ico__path' d='M263.255,4848.75h15' />
                <path class='ico__path' d='M255.755,4828.5a.75.75,0,0,1,.75-.75h3a.75.75,0,0,1,.75.75v3a.75.75,0,0,1-.75.75h-3a.75.75,0,0,1-.75-.75Z' />
                <path class='ico__path' d='M255.755,4837.5a.75.75,0,0,1,.75-.75h3a.75.75,0,0,1,.75.75v3a.75.75,0,0,1-.75.75h-3a.75.75,0,0,1-.75-.75Z' />
                <path class='ico__path' d='M255.755,4846.5a.75.75,0,0,1,.75-.75h3a.75.75,0,0,1,.75.75v3a.75.75,0,0,1-.75.75h-3a.75.75,0,0,1-.75-.75Z' />
              </g>
            </svg>
          </span>
        </button>
      </li>
    </ul>";

  return $content;
});
gsc_meta("filters-grid-and-list", [ATOM]);
gsc_test("filters-grid-and-list", "", function() {
  echo gsc("filters-grid-and-list", []);
});
gsc_test("filters-grid-and-list", "Custom Class", function() {
  echo gsc("filters-grid-and-list", [
    "content" => [
      "class" => "custom-class"
    ]
  ]);
});
