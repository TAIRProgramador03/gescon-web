<?php
    require './templates/header.html';
?>
<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<!-- jQuery (Necesario) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<style>
    #preloader {
        position: fixed;
        top: 0;
        left: 250px;
        width: calc(100% - 250px);;
        height: 100%;
        background-color: #fff; 
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 1000; 
    }

    .gif-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px; 
    }

    .gif-container img {
        width: 60px; 
        animation: fadein 1.5s ease-in-out infinite;
    }

    .welcome-message {
        font-size: 20px;
        margin-top: 20px;
        font-weight: bold;
        color: #019fff;
    }

    @keyframes fadein {
        0%, 100% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
    }

    body.loaded .sidebar,
    body.loaded .home-section {
        display: block;
    }

    body:not(.loaded) .sidebar,
    body:not(.loaded) .home-section {
        display: none;
    }
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    body{
        background: #f5f5f5;
    }

    main{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        align-content: center;
    }

    .contenedor{
        border-radius: 10px;
        background: white;
        color: black;
        width: 100%;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
        /*padding: 20px 20px;*/
        --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .form-registrar{
        align-items: center;
        justify-content: center;
        display: flex;
        flex-direction: column;
        padding-bottom: 20px;
    }

    .form-one, .form-two, .form-three, .form-four, .form-five, .form-six, .form-seven{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: space-around;
        justify-content: space-around;
        align-items: stretch;
        width: 100%;
        padding-top: 10px;
        padding-bottom: 10px; 
        gap: 20px;
    }

    .form-cliente-cbo{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: space-around;
        justify-content: space-around;
        align-items: stretch;
        width: 100%;
        padding-top: 20px;
        padding-bottom: 10px;
        gap: 20px;
    }

    .cbo-form-cliente{
        height: 30px;
        border-radius: 5px;
        width: 60%;
        position: relative;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
    }

    .cbo-form-cliente-deta{
        height: 30px;
        border-radius: 5px;
        position: relative;
        
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
    }

    .form-cliente{
        width: 45%;
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .form-cliente input{
        height: 25px;
        border-radius: 5px;
        border: 1px solid; 
    }

    .form-cliente label{
        width: 35%;
    }

    .cbo-registrar{
        width: 100%;
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
        align-content: space-around;
        justify-content: space-around;
    }

    .cbo-registrar label{
        width: 12%;
    }

    .resumen-form-contrato{
        width: 60%;
    }

    .dta{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
        align-content: space-around;
        align-items: center;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-style: normal;
        background: #ffffff;
        color: black;
    }

    .form-tittle{
        background: #525252;
        color: white;
        width: 100%;
        padding: 20px 0px;
        text-align: center;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        font-size: 16px;
    }

    .tabla-form{
        width: 100%;
        display: grid;
        justify-items: start;
    }
    
    .tabla-form::-webkit-scrollbar{
        width: 15px;
    }

    .tabla-form::-webkit-scrollbar-track{
        background:rgb(123, 152, 196);
        border-radius: 50px;
    }

    .tabla-form::-webkit-scrollbar-thumb{
        background:rgb(185, 185, 185);
        border-radius: 50px;
    }
    
    .area-campo{
        resize: none; 
        width: 77.5%;
        padding: 10px 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%; 
        display: block; 
        overflow-x: auto; 
        white-space: nowrap;
        color: #000; 
        padding: 10px 22px;
    }

    th, td {
        border: 1px solid #8d8d8d;
        padding: 8px 12px; 
        text-align: center; 
    }

    th {
        background-color: #525252;
        color: white;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 12px;
        font-weight: <weight>;
        font-style: normal;
    }

    td {
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 12px;
        font-weight: <weight>;
        font-style: normal;
    }

    .tdh{
        padding: 5px 0;
        font-size: 12px;
    }

    th:nth-child(1), td:nth-child(1) { width: 5%; } 
    th:nth-child(2), td:nth-child(2) { width: 35%; } 
    th:nth-child(3), td:nth-child(3) { width: 15%; } 
    th:nth-child(4), td:nth-child(4) { width: 5%; } 
    th:nth-child(5), td:nth-child(5) { width: 5%; } 
    th:nth-child(6), td:nth-child(6) { width: 5%; } 
    th:nth-child(7), td:nth-child(7) { width: 5%; } 
    th:nth-child(8), td:nth-child(8) { width: 5%; } 
    th:nth-child(9), td:nth-child(9) { width: 10%; } 
    th:nth-child(10), td:nth-child(10) { width: 10%; } 

    th:nth-child(1) input, td:nth-child(1) input { width: 35px; }
    th:nth-child(2) input, td:nth-child(2) input { width: 156px; }
    th:nth-child(3) input, td:nth-child(3) input { width: 100px; } 
    th:nth-child(4) input, td:nth-child(4) input { width: 78px; } 
    th:nth-child(5) input, td:nth-child(5) input { width: 78px; }  
    th:nth-child(6) input, td:nth-child(6) input { width: 78px; } 
    th:nth-child(7) input, td:nth-child(7) input { width: 78px; } 
    th:nth-child(8) input, td:nth-child(8) input { width: 78px; } 
    th:nth-child(9) input, td:nth-child(9) input { width: 100px; } 
    th:nth-child(10) input, td:nth-child(10) input { width: 100px; } 

    tr:hover {
        background-color: #f3f3f3;
        color: #fff;
        cursor: pointer;
    }

    .table-detalle input{
        height: 25px;
        border-radius: 5px;
        border: 1px solid;
    }

    td select{
        width: 156px;
    }

    .tabla-form table::-webkit-scrollbar{
        width: 15px;
    }

    .tabla-form table::-webkit-scrollbar-track{
        background:rgb(123, 152, 196);
        border-radius: 50px;
    }

    .tabla-form table::-webkit-scrollbar-thumb{
        background:rgb(185, 185, 185);
        border-radius: 50px;
    }

    .file-adjunta{
        width: 60%;
        height: 92px;
        display: flex;
    }

    .file-adjunta label{
        display: flex;
        width: 100%;
        height: 48px;
        justify-content: center;
        align-items: center;
    }


    .file-upload {
      background-color: #f3f4f6;
      padding: 20px;
      border: 2px dashed #d1d5db;
      border-radius: 12px;
      text-align: center;
      position: relative;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .file-upload.dragover {
      background-color: #e5e7eb;
      border-color: #2563eb;
    }

    input[type="file"] {
      display: none;
    }

    .file-info {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
        gap: 5px;
        left: 0px;
        position: relative;
    }

    .file-info img {
      width: 32px;
    }

    .file-info span {
      font-size: 12px;
      color: #374151;
    }

    .remove-file {
      background-color: #ef4444;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 5px 10px;
      cursor: pointer;
    }

    .remove-file:hover {
      background-color: #dc2626;
    }

    #notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #d4edda;
        color: #fff;
        padding: 15px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        opacity: 0;
        transform: translateY(-20px);
        visibility: hidden; /* Aseguramos que esté oculto inicialmente */
        transition: opacity 0.5s ease, transform 0.5s ease, visibility 0s 0.5s;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-style: normal;
    }

    #notification.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease, transform 0.5s ease, visibility 0s 0s;
    }
    
    .continue-application {
        --color: #fff;
        --background: #477023;
        --background-hover: #6E8649;
        --background-left: #2B3044;
        --folder: #F3E9CB;
        --folder-inner: #BEB393;
        --paper: #FFFFFF;
        --paper-lines: #BBC1E1;
        --paper-behind: #E1E6F9;
        --pencil-cap: #fff;
        --pencil-top: #275EFE;
        --pencil-middle: #fff;
        --pencil-bottom: #5C86FF;
        --shadow: rgba(13, 15, 25, .2);
        width: 280px;
        border: none;
        outline: none;
        cursor: pointer;
        position: relative;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        line-height: 19px;
        -webkit-appearance: none;
        -webkit-tap-highlight-color: transparent;
        padding: 17px 29px 17px 69px;
        transition: background .3s;
        color: var(--color);
        background: var(--bg, var(--background));
        & > div {
            top: 0;
            left: 0;
            bottom: 0;
            width: 53px;
            position: absolute;
            overflow: hidden;
            border-radius: 10px 0 0 10px;
            background: #2a4710; /*var(--background-left);*/
            .folder {
                width: 23px;
                height: 27px;
                position: absolute;
                left: 15px;
                top: 13px;
                .top {
                    left: 0;
                    top: 0;
                    z-index: 2;
                    position: absolute;
                    transform: translateX(var(--fx, 0));
                    transition: transform .4s ease var(--fd, .3s);
                    svg {
                        width: 24px;
                        height: 27px;
                        display: block;
                        fill: var(--folder);
                        transform-origin: 0 50%;
                        transition: transform .3s ease var(--fds, .45s);
                        transform: perspective(120px) rotateY(var(--fr, 0deg));
                    }
                }
                &:before,
                &:after,
                .paper {
                    content: '';
                    position: absolute;
                    left: var(--l, 0);
                    top: var(--t, 0);
                    width: var(--w, 100%);
                    height: var(--h, 100%);
                    border-radius: 1px;
                    background: var(--b, var(--folder-inner));
                }
                &:before {
                    box-shadow: 0 1.5px 3px var(--shadow), 0 2.5px 5px var(--shadow), 0 3.5px 7px var(--shadow);
                    transform: translateX(var(--fx, 0));
                    transition: transform .4s ease var(--fd, .3s);
                }
                &:after,
                .paper {
                    --l: 1px;
                    --t: 1px;
                    --w: 21px;
                    --h: 25px;
                    --b: var(--paper-behind);
                }
                &:after {
                    transform: translate(var(--pbx, 0), var(--pby, 0));
                    transition: transform .4s ease var(--pbd, 0s);
                }
                .paper {
                    z-index: 1;
                    --b: var(--paper);
                    &:before,
                    &:after {
                        content: '';
                        width: var(--wp, 14px);
                        height: 2px;
                        border-radius: 1px;
                        transform: scaleY(.5);
                        left: 3px;
                        top: var(--tp, 3px);
                        position: absolute;
                        background: var(--paper-lines);
                        box-shadow: 0 12px 0 0 var(--paper-lines), 0 24px 0 0 var(--paper-lines);
                    }
                    &:after {
                        --tp: 6px;
                        --wp: 10px;
                    }
                }
            }
            .pencil {
                height: 2px;
                width: 3px;
                border-radius: 1px 1px 0 0;
                top: 8px;
                left: 105%;
                position: absolute;
                z-index: 3;
                transform-origin: 50% 19px;
                background: var(--pencil-cap);
                transform: translateX(var(--pex, 0)) rotate(35deg);
                transition: transform .4s ease var(--pbd, 0s);
                &:before,
                &:after {
                    content: '';
                    position: absolute;
                    display: block;
                    background: var(--b, linear-gradient(var(--pencil-top) 55%, var(--pencil-middle) 55.1%, var(--pencil-middle) 60%, var(--pencil-bottom) 60.1%));
                    width: var(--w, 5px);
                    height: var(--h, 20px);
                    border-radius: var(--br, 2px 2px 0 0);
                    top: var(--t, 2px);
                    left: var(--l, -1px);
                }
                &:before {
                    clip-path: polygon(0 5%, 5px 5%, 5px 17px, 50% 20px, 0 17px);
                }
                &:after {
                    --b: none;
                    --w: 3px;
                    --h: 6px;
                    --br: 0 2px 1px 0;
                    --t: 3px;
                    --l: 3px;
                    border-top: 1px solid var(--pencil-top);
                    border-right: 1px solid var(--pencil-top);
                }
            }
        }
        &:before,
        &:after {
            content: '';
            position: absolute;
            width: 10px;
            height: 2px;
            border-radius: 1px;
            background: var(--color);
            transform-origin: 9px 1px;
            transform: translateX(var(--cx, 0)) scale(.5) rotate(var(--r, -45deg));
            top: 26px;
            right: 16px;
            transition: transform .3s;
        }
        &:after {
            --r: 45deg;
        }
        &:hover {
            --cx: 2px;
            --bg: var(--background-hover);
            --fx: -40px;
            --fr: -60deg;
            --fd: .15s;
            --fds: 0s;
            --pbx: 3px;
            --pby: -3px;
            --pbd: .15s;
            --pex: -24px;
        }
    }

    input{
        text-align: center;
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
    }

    .body{
        flex-wrap: wrap;
        align-content: space-around;
        justify-content: space-evenly;
        flex-direction: row;
        padding: 0px 10px;
        
    }

    .clear-action {
        --color: #fff;
        --background: #BB8D3F;
        --background-hover: #d5a24b;
        --background-left: #2B3044;
        --trash: #F3E9CB;
        --trash-inner: #BEB393;
        --paper: #FFFFFF;
        --paper-lines: #BBC1E1;
        --paper-behind: #E1E6F9;
        --broom-handle: #A67855;
        --broom-bristles: #FFC107;
        --shadow: rgba(13, 15, 25, .2);
        width: 280px;
        border: none;
        outline: none;
        cursor: pointer;
        position: relative;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        line-height: 19px;
        -webkit-appearance: none;
        -webkit-tap-highlight-color: transparent;
        padding: 17px 29px 17px 69px;
        transition: background .3s;
        color: var(--color);
        background: var(--bg, var(--background));
    }

    .clear-action > div {
        top: 0;
        left: 0;
        bottom: 0;
        width: 53px;
        position: absolute;
        overflow: hidden;
        border-radius: 10px 0 0 10px;
        background: #9b7330;
    }

    .clear-action .trash {
        width: 23px;
        height: 27px;
        position: absolute;
        left: 15px;
        top: 13px;
    }

    .clear-action .trash-top {
        left: 0;
        top: 0;
        z-index: 2;
        position: absolute;
        transform: translateX(var(--fx, 0));
        transition: transform .4s ease var(--fd, .3s);
    }

    .clear-action .trash-top svg {
        width: 24px;
        height: 27px;
        display: block;
        fill: var(--trash);
        transform-origin: 0 50%;
        transition: transform .3s ease var(--fds, .45s);
        transform: perspective(120px) rotateY(var(--fr, 0deg));
    }

    .clear-action .broom {
        height: 5px;
        width: 50px;
        position: absolute;
        top: 8px;
        left: 112%;
        z-index: 3;
        background: var(--broom-handle);
        transform-origin: 50% 50%;
        transform: translateX(var(--broom-x, 0)) rotate(-30deg);
        transition: transform .4s ease var(--fd, 0s);
    }

    .clear-action .broom:before {
        content: '';
        position: absolute;
        top: 1px;
        left: -10px;
        width: 15px;
        height: 5px;
        background: var(--broom-bristles);
        transform: rotate(45deg);
        border-radius: 2px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
    }

    .clear-action .paper-clear {
        --l: 1px;
        --t: 1px;
        --w: 21px;
        --h: 25px;
        --b: var(--paper-behind);
        content: '';
        position: absolute;
        left: var(--l, 0);
        top: var(--t, 0);
        width: var(--w, 100%);
        height: var(--h, 100%);
        border-radius: 1px;
        background: var(--b);
        z-index: 1;
        transition: transform .4s ease var(--fd, .15s);
        transform: translate(var(--paper-x, 0), var(--paper-y, 0));
    }

    .clear-action:hover {
        --bg: var(--background-hover);
        --fx: -40px;
        --fr: -60deg;
        --fd: .15s;
        --fds: 0s;
        --broom-x: -25px;
        --paper-x: 3px;
        --paper-y: -3px;
    }

    @media screen and (max-width: 1690px){
        .contenedor{
            width: 100%;
        }
        
        .file-adjunta label{
            width: 100%;
        }
    }

    @media screen and (max-width: 1520px){
        .file-adjunta label{
            width: 100%;
        }
    }

    .add-action {
        --color: #fff;
        --background: #166581;
        --background-hover: #16799d;
        --background-left: #2B3044;
        --trash: #F3E9CB;
        --trash-inner: #BEB393;
        --paper: #FFFFFF;
        --paper-lines: #BBC1E1;
        --paper-behind: #E1E6F9;
        --broom-handle: #A67855;
        --broom-bristles: #FFC107;
        --shadow: rgba(13, 15, 25, .2);
        width: 280px;
        border: none;
        outline: none;
        cursor: pointer;
        position: relative;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        line-height: 19px;
        -webkit-appearance: none;
        -webkit-tap-highlight-color: transparent;
        padding: 17px 29px 17px 69px;
        transition: background .3s;
        color: var(--color);
        background: var(--bg, var(--background));
    }

    .add-action > div {
        top: 0;
        left: 0;
        bottom: 0;
        width: 53px;
        position: absolute;
        overflow: hidden;
        border-radius: 10px 0 0 10px;
        background: #0b3747;
    }

    .add-action .trash {
        width: 23px;
        height: 27px;
        position: absolute;
        left: 15px;
        top: 13px;
    }

    .add-action .trash-top {
        left: 0;
        top: 0;
        z-index: 2;
        position: absolute;
        transform: translateX(var(--fx, 0));
        transition: transform .4s ease var(--fd, .3s);
    }

    .add-action .trash-top svg {
        width: 24px;
        height: 27px;
        display: block;
        fill: var(--trash);
        transform-origin: 0 50%;
        transition: transform .3s ease var(--fds, .45s);
        transform: perspective(120px) rotateY(var(--fr, 0deg));
    }

    .add-action .broom {
        height: 5px;
        width: 50px;
        position: absolute;
        top: 8px;
        left: 112%;
        z-index: 3;
        background: var(--broom-handle);
        transform-origin: 50% 50%;
        transform: translateX(var(--broom-x, 0)) rotate(-30deg);
        transition: transform .4s ease var(--fd, 0s);
    }

    .add-action .broom:before {
        content: '';
        position: absolute;
        top: 1px;
        left: -10px;
        width: 15px;
        height: 5px;
        background: var(--broom-bristles);
        transform: rotate(45deg);
        border-radius: 2px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
    }

    .add-action .paper-clear {
        --l: 1px;
        --t: 1px;
        --w: 21px;
        --h: 25px;
        --b: var(--paper-behind);
        content: '';
        position: absolute;
        left: var(--l, 0);
        top: var(--t, 0);
        width: var(--w, 100%);
        height: var(--h, 100%);
        border-radius: 1px;
        background: var(--b);
        z-index: 1;
        transition: transform .4s ease var(--fd, .15s);
        transform: translate(var(--paper-x, 0), var(--paper-y, 0));
    }

    .add-action:hover {
        --bg: var(--background-hover);
        --fx: -40px;
        --fr: -60deg;
        --fd: .15s;
        --fds: 0s;
        --broom-x: -25px;
        --paper-x: 3px;
        --paper-y: -3px;
    }

    td select{
        width: 156px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000000;
        line-height: 28px;
    }

    .select2-container .select2-selection--single {
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
        color: black;
    }

    .select2-dropdown {
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
        color: black;
    }

    /* Cambia la fuente de los elementos dentro del desplegable */
    .select2-results__option {
        font-family: "Montserrat", serif;
        font-optical-sizing: auto;
        font-size: 13px;
        font-weight: <weight>;
        font-style: normal;
        color: black;
    }

    @media screen and (max-width: 1400px){
        .contenedor{
            width: 100%;
        }
    }
    
    @media screen and (max-width: 1270px){
        .contenedor{
            width: 100%;
        }
    }

    @media screen and (max-width: 1060px){
        .file-adjunta label{
            width: 100%;
        }
    }

    @media screen and (max-width: 960px){
        .file-adjunta label{
            width: 100%;
        }
    }

    @media screen and (max-width: 928px){
        .file-adjunta{
            height: 115px;
        }

        .file-adjunta label {
            width: 100%;
            height: 72px;
        }
    }

    @media screen and (max-width: 890px){
        .file-adjunta{
            height: 115px;
        }

        .file-adjunta label{
            width: 68%;
        }
    }

    @media screen and (max-width: 800px){
        #preloader{
            left: 0;
            width: 100%;
            height: calc(100% - 60px);
        }

        .contenedor{
            width: 100%;
        }

        .body{
            justify-content: flex-end;
            flex-direction: column;
            padding: 0px 10px;
            display: flex;
            gap: 10px;
        }
        .form-one, .form-two, .form-three, .form-four, .form-five, .form-six, .form-seven{
            justify-content: flex-end;
            flex-direction: column;
            width: 100%;
            gap: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .cbo-registrar, .form-cliente{
            padding-top: 0px;
            padding-bottom: 10px; 
        }

        .form-cliente{
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 0px;
        }

        .file-adjunta {
            height: 88px;
            width: 90%;
        }

        .file-adjunta label{
            width: 90%;
            height: 44px;
        }

        .clear-action, .continue-application{
            width: 100%;
        }

        .cbo-form-cliente, .cbo-registrar label, .form-cliente label, .resumen-form-contrato {
            width: 90%;
        }

        .form-cliente-cbo{
            padding-bottom: 0px;
            gap: 0px;
        }

        .form-cliente input {
            height: 36px;
        }

        .cbo-form-cliente {
            height: 40px;
        }

        .area-campo{
            width: 90%;
        }

        .add-action{
            width: 100%;
        }

        /*si funciona es aqui sobre el check*/
        .form-especial{
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            flex-wrap: wrap;
            align-content: flex-end;
            gap: 20px;
            align-items: center;
            position: relative;
            left: 34px;
            width: 90%;
        }

        .form-especial label{
            width: 100px;
        }
        /*si funciona es aqui sobre el check*/
    }

    .modal {
  display: none;
  position: fixed;
  z-index: 9999;
  padding-top: 60px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.7);
}

.modal-content {
  margin: auto;
  background: #fff;
  padding: 20px;
  width: 80%;
  max-width: 800px;
  border-radius: 8px;
  position: relative;
}

.close-modal {
  color: #aaa;
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close-modal:hover {
  color: #000;
}

.view-file {
  margin-right: 8px;
  cursor: pointer;
  background: none;
  border: none;
  font-size: 27px;
}
</style>
<div id="preloader">
    <div class="gif-container">
        <img src="../img/carpeta.gif" alt="Cargando...">
    </div>
    <div class="welcome-message">
        <p>¡Cargando!.....</p>
    </div>
</div>

<main>
    <div id="notification" class="hidden"></div>
    <div class="contenedor">
        <div class="form-registrar">
            <div class="form-tittle">
                <div class="form-tittle-h3">
                    <h3>Nuevo Documento Asociado</h3>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="form-cliente">
                    <label for="combo-box">Cliente(*):</label>
                    <select id="combo-cliente" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el cliente" >
                        <option value="">Seleccione un cliente</option>
                    </select>
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Doc. Padre:</label>
                    <select id="combo-contrato" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona el contrato inicial" >
                        <option value="">Seleccione un contrato</option>
                    </select>
                </div>
            </div>
            <div class="form-one">
                <div class="form-cliente">
                    <label for="combo-box">Tipo documento:</label>
                    <select id="combo-raz" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona un tipo de documento: Orden de compra, Adenda o Carta">
                        <option value="">Seleccione un tipo</option>
                        <option value="1">Adenda</option>
                        <option value="2">Carta</option>
                        <option value="3">Orden de Compra</option>
                        <option value="4">Orden de Servicio</option>
                    </select>
                </div>
                <div class="form-cliente">
                    <label for="combo-box">N° de documento:</label>
                    <input id="text-nro-contra" name="nro-contrato" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="El número del documento debe ser un correlativo (CLIENTE-MM-AAAA-0001)">
                </div>
            </div>
            <div class="form-two">
                <div class="form-cliente">
                    <label for="combo-box">Cant. Vehiculos:</label>
                    <input id="text-veh" name="Sev" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehiculos contratados">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Duracion (Meses):</label>
                    <input id="text-dura" name="Duracion" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Duracion del contrato en meses">
                </div>
            </div>
            <!--<div class="form-three">
                <div class="form-cliente">
                    <label for="combo-box">Costo Por KM:</label>
                    <input id="text-cpk" name="Costo" type="text" class="resumen-form-contrato">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Recorrido Men:</label>
                    <input id="text-rm" name="Recorrido" type="text" class="resumen-form-contrato">
                </div>
            </div>-->
            <div class="form-four">
                <div class="form-cliente">
                    <label for="combo-box">$ KM Adicional:</label>
                    <input id="text-adic" name="Adicional" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Tarifa por km adicional de recorrido 0.000">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Bolsa KM Total:</label>
                    <input id="text-bolsa" name="Bolsa" type="text" class="resumen-form-contrato tooltip-input" data-tooltip="Km total a recorrer por unidad">
                </div>
            </div>
            <div class="form-five">
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Sup:</label>
                    <input id="text-sup" name="Sup" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Superficie">
                </div>
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Soc:</label> 
                    <input id="text-soc" name="Soc" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Socavon">
                </div>
            </div>
            <div class="form-six">
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Ciu:</label>
                    <input id="text-ciu" name="Ciu" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Ciudad">
                </div>
                <div class="form-cliente">
                    <label for="combo-box"># Veh. Sev:</label>
                    <input id="text-sev" name="Sev" type="text" class="resumen-form-contrato tooltip-input" value="0" data-tooltip="Cantidad de vehículos en Severo">
                </div>
            </div>
            <div class="form-six">
                <div class="form-cliente custom-date">
                    <label for="combo-box">Fecha Firma:</label>
                    <input id="text-firma" name="Firma" type="date" class="resumen-form-contrato dta tooltip-input" data-tooltip="Fecha de la firma del contrato">
                </div>
                <div class="form-cliente">
                    <label for="combo-box">Motivo:</label>
                    <select id="combo-motivo" name="opciones" class="cbo-form-cliente tooltip-input" data-tooltip="Selecciona un motivo: Ampliación, Renovación, Cambio de datos del cliente">
                        <option value="">Seleccione un Motivo</option>
                        <option value="1">Ampliación</option>
                        <option value="2">Renovación</option>
                        <option value="3">Cambio de datos del cliente</option>
                        <option value="3">Actualización de condiciones del cliente</option>
                        <option value="4">Devolución</option>
                    </select>
                </div>
            </div>
            <div class="form-six form-adjun">
                <div class="form-cliente adjunto-pdf">
                    <label for="combo-box">Adjuntar pdf:</label>
                    <div class="file-adjunta">
                        <label class="file-upload tooltip-input" id="dropZone" data-tooltip="Arrastra o seleccione un archivo en pdf">
                            <span id="uploadMessage">Haz clic o arrastra un archivo aquí</span>
                            <input type="file" id="fileInput" accept=".pdf">
                            <div class="file-info" id="fileInfo">
                                <img src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Icon">
                                <span id="fileName"></span>
                                <button class="view-file" id="viewFile">👁️</button>
                                <button class="remove-file" id="removeFile">X</button>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-cliente form-especial">
                    <label for="combo-box">Doc. Especial:</label>
                    <input id="especial" name="especial" type="checkbox" class="check-form-contrato tooltip-input" data-tooltip="Contrato especial, Cuando un contrato tiene varios periodos de finalización.">
                </div>
            </div>
            <div class="form-seven">
                <div class="tabla-form">
                    <table id="tabla-dinamica">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Modelo</th>
                                <th>Tipo terreno</th>
                                <th>Tarifa</th>
                                <th>CPK</th>
                                <th>RM</th>
                                <th>Cantidad</th>
                                <th>Duracion</th>
                                <th>Compra Veh. ($)</th>
                                <th>Venta Veh. ($)</th>
                            </tr>
                        </thead>
                        <tbody id="contratos-tbody" class="table-detalle">
                            <tr>
                                <td><input type="text" name="item[]" value="1" disabled></td>
                                <td>
                                    <select name="tipo_modelo[]" class="cbo-form-cliente modelo-select tooltip-input" id="tipoModelo" style="width: 100%;" data-tooltip="Selecciona el modelo">
                                        <option value="">Seleccione un modelo</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="tipo_terreno[]" class="cbo-form-cliente-deta tooltip-input" style="width: 100%;" data-tooltip="Seleccione el tipo de terreno">
                                        <option value="4">Seleccione el tipo</option>
                                        <option value="0">Superficie</option>
                                        <option value="1">Socavon</option>
                                        <option value="2">Ciudad</option>
                                        <option value="3">Severo</option>
                                    </select>
                                </td>
                                <td><input type="text" name="tarifa[]" value="" class="tooltip-input" data-tooltip="Tarifa del contrato estipulado"></td>
                                <td><input type="text" name="cpk[]" value="" class="tooltip-input" data-tooltip="Costo por kilometraje"></td>
                                <td><input type="number" name="rm[]" value="0" class="tooltip-input" data-tooltip="Recorrido mensual del vehiculo"></td>
                                <td><input type="number" name="cantidad[]" value="0" class="tooltip-input" data-tooltip="Cantidad de unidades"></td>
                                <td><input type="text" name="duracion[]" value="0" class="tooltip-input" data-tooltip="Duracion vehicular" disabled></td>
                                <td><input type="text" name="compra_veh[]" value="" class="tooltip-input" data-tooltip="Precio promedio de la compra del vehiculo"></td>
                                <td><input type="text" name="precio_veh[]" value="" class="tooltip-input" data-tooltip="Precio promedio de la venta del vehiculo"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="cbo-registrar">
                    <label for="combo-box">Descripcion:</label>
                    <textarea id="story" name="story" rows="4" placeholder="" class="area-campo tooltip-input" data-tooltip="Ingrese aqui algun comentario adicional"></textarea>
                </div>
            </div>
            <div class="form-cliente-cbo">
                <div class="cbo-registrar body">
                    <button class="add-action" id="btnAddVeh" style="font-weight: 800;">
                        <div>
                            <div class="broom"></div>
                            <div class="trash">
                                <div class="trash-top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper-clear"></div>
                            </div>
                        </div>
                        Adicionar
                    </button>
                    <button class="clear-action" id="btnClear" style="font-weight: 800;">
                        <div>
                            <div class="broom"></div>
                            <div class="trash">
                                <div class="trash-top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper-clear"></div>
                            </div>
                        </div>
                        Limpiar
                    </button>
                    <button class="continue-application" id="grabarButton" style="font-weight: 800;">
                        <div>
                            <div class="pencil"></div>
                            <div class="folder">
                                <div class="top">
                                    <svg viewBox="0 0 24 27">
                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                                    </svg>
                                </div>
                                <div class="paper"></div>
                            </div>
                        </div>
                        Grabar
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="pdfModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" id="closeModal">&times;</span>
    <iframe id="modalPdfViewer" width="100%" height="500px"></iframe>
  </div>
</div>
<script type="module">

    document.addEventListener("DOMContentLoaded", function () {
        const tooltip = document.createElement("div");

        tooltip.style.position = "fixed";
        tooltip.style.background = "black";
        tooltip.style.color = "white";
        tooltip.style.padding = "5px 10px";
        tooltip.style.borderRadius = "5px";
        tooltip.style.fontSize = "12px";
        tooltip.style.display = "none";
        tooltip.style.opacity = "0";
        tooltip.style.transition = "opacity 0.2s ease-in-out";
        tooltip.style.zIndex = "1000";
        tooltip.style.whiteSpace = "nowrap";
        document.body.appendChild(tooltip);

        document.addEventListener("mouseenter", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                const tooltipText = event.target.getAttribute("data-tooltip");
                if (!tooltipText) return;

                tooltip.textContent = tooltipText;
                tooltip.style.display = "block";
                tooltip.style.opacity = "1";
            }
        }, true);

        document.addEventListener("mousemove", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                let x = event.clientX + 10;
                let y = event.clientY + 10;

                if (x + tooltip.offsetWidth > window.innerWidth) {
                    x = event.clientX - tooltip.offsetWidth - 10;
                }
                if (y + tooltip.offsetHeight > window.innerHeight) {
                    y = event.clientY - tooltip.offsetHeight - 10;
                }

                tooltip.style.left = `${x}px`;
                tooltip.style.top = `${y}px`;
            }
        });

        document.addEventListener("mouseleave", function (event) {
            if (!event.target || !event.target.classList) return;  // Evita error en `null`
            if (event.target.classList.contains("tooltip-input")) {
                tooltip.style.opacity = "0";
                setTimeout(() => {
                    tooltip.style.display = "none";
                }, 200);
            }
        }, true);
    });


    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileInfo = document.getElementById('fileInfo');
    const fileNameDisplay = document.getElementById('fileName');
    const uploadMessage = document.getElementById('uploadMessage');
    const removeFileButton = document.getElementById('removeFile');

    window.onload = function () {
        setTimeout(() => {
            document.body.classList.add('loaded');
            document.getElementById('preloader').style.display = 'none';
        }, 2000);
        fileInfo.style.display = 'none'; // Asegúrate de que la información del archivo no aparezca.
        uploadMessage.style.display = 'block'; // Muestra el mensaje inicial.
        fileInput.value = ''; // Limpia el campo de archivo si existe algo previamente.
    };

    // Mostrar nombre del archivo al seleccionar
    fileInput.addEventListener('change', handleFile);

    // Eventos para drag and drop
    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.classList.remove('dragover');

        const file = event.dataTransfer.files[0];
        if (file) {
            fileInput.files = event.dataTransfer.files; // Asignar archivo al input
            handleFile();
        }
    });

    // Mostrar archivo y cambiar el contenido visual
    function handleFile() {
        const file = fileInput.files[0];
        if (file) {
            uploadMessage.style.display = 'none'; // Ocultar mensaje de carga
            fileInfo.style.display = 'flex'; // Mostrar el área con el archivo
            fileNameDisplay.textContent = truncateFileName(file.name); // Mostrar el nombre truncado del archivo
        }
    }

    const viewFileButton = document.getElementById('viewFile');
    const pdfModal = document.getElementById('pdfModal');
    const modalPdfViewer = document.getElementById('modalPdfViewer');
    const closeModal = document.getElementById('closeModal');

    // Evento para abrir el modal con vista previa
    viewFileButton.addEventListener('click', () => {
        const file = fileInput.files[0];
        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            modalPdfViewer.src = fileURL;
            pdfModal.style.display = 'block';
        }
    });

    // Cerrar modal
    closeModal.addEventListener('click', () => {
        pdfModal.style.display = 'none';
        modalPdfViewer.src = '';
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', (event) => {
        if (event.target === pdfModal) {
            pdfModal.style.display = 'none';
            modalPdfViewer.src = '';
        }
    });

    // Función para truncar el nombre del archivo
    function truncateFileName(name) {
        const maxLength = 25;
        if (name.length <= maxLength) return name;

        const fileExtension = name.slice(name.lastIndexOf('.'));
        const truncatedName = name.slice(0, maxLength - fileExtension.length - 3);
        return truncatedName + '...' + fileExtension;
    }

    // Eliminar archivo seleccionado
    removeFileButton.addEventListener('click', () => {
        fileInput.value = ''; // Limpiar input
        fileInfo.style.display = 'none'; // Ocultar el área del archivo
        uploadMessage.style.display = 'block'; // Mostrar mensaje de carga
    });

    $(document).ready(function() {
        $("#tipoTerreno").select2({
            placeholder: "Seleccione el tipo",
            allowClear: false // Desactiva la "X"
        });
    });

    $(document).ready(function() {
        $("#tipoModelo").select2({
            placeholder: "Seleccione el tipo",
            allowClear: false // Desactiva la "X"
        });
    });

</script>
<script type="module" src="../js/registrar_documentos.js"></script>
<?php
    require './templates/footer.html';
?>