<?php
if ($method === 'GET') {

    if ($context === 'users') {
        if ($acao === 'getAll') {
            if ($parametro === '') {
                print_r(db::getDataUsers());
                exit;
            } else if ($parametro === 'er') {
                print_r(db::getDataUsers('ER'));
                exit;
            } else if ($parametro === 'lr') {
                print_r(db::getDataUsers('LR'));
                exit;
            } else{
                print_r(db::getDataUser($parametro));
            }
        }
    }else{
        print_r(db::getDataUser($parametro));
    }
}