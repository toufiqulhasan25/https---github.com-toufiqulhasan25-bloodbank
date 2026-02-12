<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* আপনার দেওয়া মূল CSS - যা পারফেক্ট কাজ করছে */
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 0; }
        .certificate-border { border: 15px solid #dc3545; height: 90vh; padding: 40px; position: relative; }
        .content { text-align: center; border: 2px solid #eee; padding: 50px; height: 80%; }
        .header { color: #dc3545; font-size: 50px; margin-bottom: 20px; text-transform: uppercase; }
        .name { font-size: 35px; font-weight: bold; border-bottom: 2px solid #333; display: inline-block; padding: 0 50px; }
        .footer { margin-top: 50px; width: 100%; }
        .hospital-stamp { float: left; width: 200px; text-align: left; }
        .system-seal { float: right; width: 200px; text-align: right; }
    </style>
</head>
<body>
    <div class="certificate-border">
        <div class="content">
            <div class="header">Certificate of Appreciation</div>
            
            <p style="font-size: 20px; margin-top: 10px;">This certificate is proudly presented to</p>
            
            <div class="name">{{ $user->name }}</div>
            
            <p style="font-size: 18px; margin-top: 30px; line-height: 1.6;">
                For the noble and selfless act of donating <b style="color: #dc3545;">{{ $donation->blood_group }}</b> blood on <br>
                <b>{{ \Carbon\Carbon::parse($donation->date)->format('d F, Y') }}</b> at 
                <b>{{ $donation->hospital->name }}</b>.
            </p>
            
            <p style="font-size: 16px; color: #666; margin-top: 20px;">
                Your life-saving contribution helps save lives and inspires our community to come forward for this noble cause.
            </p>

            <div class="footer">
                <div class="hospital-stamp">
                    <p style="margin-bottom: 5px;">___________________</p>
                    <small style="font-weight: bold;">Hospital Authority</small>
                </div>
                <div class="system-seal">
                    <p style="margin-bottom: 5px; text-align: right;">___________________</p>
                    <small style="font-weight: bold; display: block; text-align: right;">NIYD Blood Network</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>