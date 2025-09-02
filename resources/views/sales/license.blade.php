<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Registration of Ballistic Signature - Print</title>

    <style>
        /* Page / print setup */
        @page {
            size: A4;
            margin: 10mm;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            -webkit-print-color-adjust: exact;
            color: #111;
            background: #fff;
            font-family: "Poppins", Arial, sans-serif;
            font-weight: 300;
            font-size: 18px;
            line-height: 1.45;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            /* takes all space between header and footer */
            max-width: 760px;
            margin: 6mm auto;
            /* padding: 12px 14px; */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        header {
            text-align: center;
            margin-bottom: 6px;
        }

        .logo {
            max-width: 400px;
            display: inline-block;
        }

        hr.divider {
            height: 1px;
            border: none;
            background: #6b6b6b;
            margin: 10px 0 12px;
        }

        .content {
            flex: 1;
            /* pushes footer down */
            padding: 0 4px;
        }

        .to-block {
            margin-bottom: 8px;
        }

        .to-block p {
            margin: 4px 0;
        }

        .subject {
            margin: 10px 0;
            font-weight: 600;
        }

        .subject .label {
            font-weight: 600;
            margin-right: 8px;
        }

        .subject .underlined {
            text-decoration: underline;
            text-decoration-thickness: 1.4px;
            text-underline-offset: 4px;
            font-weight: 600;
        }

        .form-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 8px 0;
        }

        .form-row .label {
            min-width: 150px;
            width: 170px;
            /* font-size: 13px; */
            color: #111;
        }

        .field {
            flex: 1;
            border-bottom: 1px solid #111;
            text-align: center
        }

        .inline {
            display: flex;
            /* gap: 10px; */
            align-items: center;
        }

        .inline .small-label {
            white-space: nowrap;
        }

        .inline .short-field {
            width: 160px;
            border-bottom: 1px solid #111;
            display: inline-block;
            text-align: center
        }

        .inline .short-field.tiny {
            width: 180px;
        }

        .two-cols {
            display: flex;
            /* gap: 18px; */
            align-items: center;
            margin: 6px 0;
        }

        .two-cols .col-label-small {
            width: 190px;
        }

        .two-cols .col-label-large {
            width: 90px;
        }

        .two-cols .col-field {
            border-bottom: 1px solid #111;
            flex: 1;
            text-align: center
        }

        .stacked {
            margin-top: 6px;
        }

        .caption {
            text-align: right;
            margin-top: 10px;
            font-size: 13px;
            color: #222;
        }

        footer {
            margin-top: auto;
        }

        .lab {
            text-align: center;
            font-weight: 700;
            margin-top: 12px;
            letter-spacing: 0.8px;
        }

        .address {
            text-align: center;
            margin-top: 5px;
            font-size: 14px;
            color: #222;
            letter-spacing: 0.6px;
        }
    </style>
</head>

<body>
    <div class="container" role="document">
        <!-- HEADER -->
        <header>
            <img src="{{ url('/logo.png') }}" alt="" width="250" class="logo logo-lg" />
        </header>
        <hr class="divider">

        <!-- CONTENT -->
        <main class="content">
            <section class="to-block" aria-label="recipient">
                <p>To,</p>
                <p>
                    AIGP Forensic Science Laboratory<br>
                    Police Head Quarter South. y<br>
                    Garden Road Karachi.
                </p>
            </section>

            <section class="subject" aria-label="subject">
                <span class="label">SUBJECT:</span>
                <span class="underlined">REGISTRATION OF BALLISTIC SIGNATURE</span>
            </section>

            <section class="declaration" aria-label="declaration">
                <p>It is certified that we have sold one weapon vide</p>

                <div class="inline form-row" style="margin-top:6px;">
                    <span class="small-label">Receipt No.</span>
                    <span class="short-field">{{ $license->saleDetail->master->transaction_no ?? '' }}</span>
                    <span style="min-width:35px; display:inline-block;"></span>
                    <span class="small-label">Dated</span>
                    <span class="short-field tiny">{{ $license->saleDetail->master->transaction_date ?? '' }}</span>
                </div>

                <p style="margin-top:10px;">The Details of purchaser: License & Weapon are enclosed</p>

                <div class="form-row">
                    <div class="label">Name of License</div>
                    <div class="field">{{ $license->license_name }}</div>
                </div>

                <div class="form-row">
                    <div class="label">License No.</div>
                    <div class="field">{{ $license->license_no }}</div>
                </div>

                <div class="two-cols">
                    <div class="col-label-small">License issue date</div>
                    <div class="col-field">{{ $license->license_issue_date }}</div>
                    <div style="min-width:18px"></div>
                    <div class="col-label-large">Issued By</div>
                    <div class="col-field">{{ $license->issued_by }}</div>
                </div>

                <div class="two-cols">
                    <div class="col-label-large">CNIC No.</div>
                    <div class="col-field">{{ $license->cnic_no }}</div>
                    <div style="min-width:18px"></div>
                    <div class="col-label-large">Contact</div>
                    <div class="col-field">{{ $license->contact_no }}</div>
                </div>

                <div class="form-row stacked">
                    <div class="label">Weapon Type</div>
                    <div class="field">{{ $license->weapon_type }}</div>
                </div>

                <div class="form-row">
                    <div class="label">Weapon No.</div>
                    <div class="field">{{ $license->weapon_no }}</div>
                </div>

                <div class="caption">Along with 2 Fired CTGS with This Weapon</div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer>
            <div class="lab">AIGP FORENSIC SCIENCE LABORATORY</div>
            <hr class="divider">
            <div class="address">
                SAMIHA MANZIL MEER KARM ALI TALPUR ROAD SADDAR - KARACHI - 74400<br>
                PHONE : 021–35678043, 021–35213288
            </div>
        </footer>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>
</html>
