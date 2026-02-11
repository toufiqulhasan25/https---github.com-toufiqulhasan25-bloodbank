<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { 
            size: a4 landscape; 
            margin: 0; 
        }
        
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Helvetica', sans-serif; 
            width: 100%;
            height: 100%;
            color: #333;
        }

        .cert-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 40px;
            box-sizing: border-box;
        }

        /* ডাবল বর্ডার ডিজাইন */
        .outer-border {
            border: 15px solid #f8f9fa;
            height: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .inner-border {
            border: 2px solid #dc3545;
            height: 98%;
            margin: 0.5%;
            padding: 40px;
            text-align: center;
            box-sizing: border-box;
            position: relative;
            background-color: #fff;
        }

        /* টাইটেল ডিজাইন */
        .title { 
            font-size: 50px; 
            margin: 0; 
            color: #1a1a1a;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitle { 
            font-size: 16px; 
            letter-spacing: 7px; 
            color: #666; 
            margin-top: 5px;
            text-transform: uppercase;
        }

        .present-text {
            margin-top: 40px;
            font-size: 20px;
            font-style: italic;
            color: #555;
        }

        .name { 
            font-size: 45px; 
            color: #dc3545; 
            margin: 15px 0; 
            font-weight: bold;
            text-decoration: none;
            border-bottom: 2px solid #f0f0f0;
            display: inline-block;
            padding: 0 40px;
        }

        .text { 
            font-size: 19px; 
            line-height: 1.6; 
            color: #444; 
            margin: 20px 80px;
        }

        .highlight {
            color: #000;
            font-weight: bold;
        }

        /* ফুটার এবং সিগনেচার */
        .footer {
            position: absolute;
            bottom: 60px;
            left: 0;
            right: 0;
            width: 100%;
            padding: 0 60px;
        }

        .signature-section {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-box {
            text-align: center;
            width: 40%;
            border-top: 2px solid #444;
            padding-top: 8px;
        }

        .sign-text {
            font-size: 15px;
            font-weight: bold;
            color: #222;
        }

        .date-text {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="cert-container">
        <div class="outer-border">
            <div class="inner-border">
                
                <div class="title">CERTIFICATE</div>
                <div class="subtitle">of appreciation</div>
                
                <p class="present-text">This is to proudly certify that</p>
                
                <div class="name">{{ strtoupper($user->name) }}</div>
                
                <div class="text">
                    In grateful recognition of your heroic and selfless contribution 
                    to humanity by donating blood on 
                    <span class="highlight">{{ date('d F, Y', strtotime($donation->date)) }}</span>. 
                    Your generosity serves as an inspiration and helps save precious lives.
                </div>

                <div class="footer">
                    <table class="signature-section">
                        <tr>
                            <td class="signature-box">
                                <span class="sign-text">NIYD Blood Bank</span><br>
                                <span class="date-text">Authorized Signature</span>
                            </td>
                            <td style="width: 20%;"></td> <td class="signature-box">
                                <span class="sign-text">{{ $date }}</span><br>
                                <span class="date-text">Date Issued</span>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>