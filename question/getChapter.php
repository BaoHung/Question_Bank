<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$Subjects = simplexml_load_file("../xml/Subjects.xml");
$subject_id = filter_input(INPUT_GET, 'subject_id');

$Subjects->xpath('//Questions/Question[@subject_id="' . $subject_id . '"]');
