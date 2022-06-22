<?php 

$defaults = [
    "content" => [
        "symbol" => true,
        "company" => "Gravity Switch",
        "forward" => true // true = company - symbol else symbol - company
    ],
    "style" => [
        "class" => '',
        "id" => '',
        "attrs" => []
    ]
];

gsc_define("copyright", $defaults, function($data) {
    $symbol = $data["content"]["symbol"];
    $company = $data["content"]["company"];
    $forward = $data["content"]["forward"];

    $class_attr = "copyright ";
    if (!empty($data["style"]["class"])) {
        $class_attr .= " {$data["style"]["class"]} ";
    }

    $id_attr = "";
    if (!empty($data["style"]["id"])) {
        $id_attr = "id='{$data["style"]["id"]}'";
    }

    $misc_attrs = "";
    if (!empty($data["style"]["attrs"])) {
        foreach ($data["style"]["attrs"] as $attr_name=>$attr_value) {
            $misc_attrs .= " $attr_name='$attr_value' ";
        }
    }

    $class_attr = "class='{$class_attr}'";

    $html = "";

    $company_html = "{$company}";
    $symbol_html = "©";
    $date_html = date("Y");

    if ($forward) {
        $html .= "<p {$class_attr} {$id_attr} {$misc_attrs}>{$company_html} {$symbol_html}{$date_html}</p>";
    } else {
        $html .= "<p {$class_attr} {$id_attr} {$misc_attrs}>{$symbol_html}{$date_html} {$company_html}</p>";
    }

    return $html;
});

gsc_meta("copyright", [ATOM]);
gsc_test("copyright", "forward", function() {
    echo gsc("copyright", []);
});
gsc_test("copyright", "backwards", function() {
    echo gsc("copyright", [
        "content" => [
            "forward" => false
        ]
    ]);
});