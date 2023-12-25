<style>
        .pos-table-row:hover {
            cursor: pointer;
        }

        ::-webkit-scrollbar {
            width: 7px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .btn_block {
            width: 100%;
            /* font-weight: bold; */
            border-radius: 0px;
        }

        /* Auto Change background */

        .mydiv {
            width: 100%;
            height: 100%;
            color: black;
            font-weight: bold;
            animation: myanimation 5s infinite;
        }

        @keyframes myanimation {
            0% {
                background-color: #39A34B;
                color: white;
            }

            25% {
                background-color: #F37216;
                color: white;
            }

            50% {
                background-color: #39A34B;
                color: white;
            }

            75% {
                background-color: #F37216;
                color: white;
            }

            100% {
                background-color: #39A34B;
                color: white;
            }
        }

        .select2-selection__rendered {
            line-height: 30px !important;
        }

        .select2-container .select2-selection--single {
            height: 30px !important;
        }

        .select2-selection__arrow {
            height: 30px !important;
        }

        .boxHistory{
            height: 106px;
            border: 1px solid black;
            padding:1.2rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:black;
            cursor: pointer;
        }

        .box_table0{
            height: 106px;
            background-color:#9b0005;
            padding:1.5rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:white;
            cursor: pointer;
        }
        .box_table1{
            height: 106px;
            background-color:#4168B7;
            padding:1.5rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:white;
            cursor: pointer;
        }
        .box_table2{
            height: 106px;
            background-color:#006B00;
            padding:1.5rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:white;
            cursor: pointer;
        }
        .box_table3{
            height: 106px;
            background-color:#CE8045;
            padding:1.5rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:white;
            cursor: pointer;
        }
        .box_table4{
            height: 106px;
            background-color:#E05123;
            padding:1.5rem;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            font-size: 16px;
            color:white;
            cursor: pointer;
        }
        .box_table:hover{
            background-color: #DB4900;
        }


        

        input[readonly] {
            background-color: #EFEFEF !important;
        }

        label {
            font-size: 15px !important;
        }

        #printMe {
            page-break-before: always;
            background-image: none !important;
        }


        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

        @media print {
            @page {
                margin: 0;
            }
        }

        .offcanvas-footer{
            padding: 1rem 1rem;
            border-top: 1px solid #dee2e6;
        }


        input[readonly] {
            background-color: #EFEFEF !important;
        }

        label {
            font-size: 15px !important;
        }

        .bottom_top {
            position: absolute;
            top: 156px;
            right: 0px;
            background: #DB4900;
            color: white;
            padding: 3px;
            width: 72px;
            text-align: center;
            opacity: 0.8;
            box-shadow: 4px 4px 4px 1px #888888;
        }
        .btn_caculator{
            padding: 25px !important;
            font-size:20px;
            border-color: white !important;
        }

        .calculator_price{
            height: 40px;
            font-size:18px !important;
        }

        .label_bill{
            font-weight: 400 !important;
        }

    </style>