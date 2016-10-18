<html>
	    <head>
	        <title>Just a MockUp</title>
	        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	        <meta charset="utf-8">
	        <script src="JS/jquery.js"></script>
	        <script src="JS/editConfigJs2.js"></script>
	        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	        <link href="CSS/editConfig.css" rel="stylesheet" media="screen">
	        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	        <script src="bootstrap/js/bootstrap.min.js"></script>
	    </head>
	    <body>
			<?php
				//this page is only a test to simulate the AEgIS runlog, I don't use the real runlog
				//to avoid to share uselessly important information (the information below are fake data)
			?>
			<p>
			date: 18/8/2016;	
			37545 simple catch and dump, BC centered, low hot dump(hD);
			37546 simple catch and dump, BC centered, low hD;
			37547 simple catch and dump, BC centered, low hD;
			37548 simple catch and dump, BC centered, low intensity;
			37549 simple catch and dump, BC centered, low intensity;
			37550 simple catch and dump, BC better, hD  7952;
			37551 simple catch and dump, BC better, hD 11223, total 14683;
			37552 simple catch and dump, BC better, hD 11922, total 14430;
			37553 simple catch and dump, BC good,   hD 11907, total 15179;
			37554 simple catch and dump, BC good,   hD 11933, total 15119;
			37555 simple catch and dump, BC good,   hD 12930, total 15639;

			date: 19/8/2016;
			***** test pbar RW v8 (0.1MHz on e-RW) and transfer to 1T
			37556 pbar RW v8, 2nd step RW 0.5MHz             hD 3944 cD 3018 r(40  86) "high cD wrt hD" ;
			37557 transfer (storage B3,B4   20s)             hD 4560 cD    0           "losses in 157.296 156.8 during storage in B3,B4";
			37558 pbar RW v8, 2nd step RW 1.0MHz             hD 4507 cD 2318 r(27 148);
			37559 pbar RW v8, 2nd step RW 1.1MHz             hD 3921 cD 2215 r(27 152);
			37560 transfer (storage B3,B4  20ms)             hD 4507 cD    0           "we see loss in same pos, cold dump very small";
			37561 pbar RW v8, 2nd step RW 1.2MHz             hD 3926 cD 2800 r(25 166);
			37562 pbar RW v8, 2nd step RW 1.3MHz             hD 4920 cD 2718;
			37563 pbar RW v8, 2nd step RW 1.4MHz             hD 4141 cD 2715;
			37564 pbar RW v8, 2nd step RW 1.5MHz             hD 4396 cD 2555;
			37565 pbar RW v8, 2nd step RW 2.0MHz   ;                   
			37566 transfer (storage B3,B4 100ms, dump MCP gain 1.5kV) --> "we see cold dump at right time but small, not seen in MCP, SC910;
			counts more than SC12, pbar die somewhere else, we see relatively high signal on SC 1T instead of dump";


			date: 21/8/2016;
			37567 transfer (storage B3,B4 100ms, dump MCP gain 1.7kV);
			37568 transfer (storage B3,B4 100ms, dump MCP gain 1.7kV, smooth step for transfer) --> "2nd peak higher than cold dump peak,
			higher than run 7567";

			37569 transfer (storage B3,B4    1s, dump MCP gain 1.7kV, smooth step);

			37570 transfer (storage B3,B4    1s, dump MCP gain 1.7kV, smooth steps, 1T re-shape dump at 30eV) --> "we see signal in MCP.
			losses: 2 peaks (during storage B3,B4?), timing is unclear." ;

			37571 transfer (storage B4,B5    1s, dump MCP gain 1.7kV, smooth steps, 1T re-shape dump at 30eV);
			37572 transfer (storage B5,B6    1s, dump MCP gain 1.7kV, smooth steps, 1T re-shape dump at 30eV);

			date: 24/8/2016;
			37573 pbar RW v8, 2nd step RW 0.3MHz;
			37574 pbar RW v8, 2nd step RW 0.4MHz;
			37575 pbar RW v8, 2nd step RW 0.6MHz "no pbar only e, there is electron in the image";
			37576 pbar RW v8, 2nd step RW 0.6MHz "no pbar";
			37577 pbar RW v8, 2nd step RW 0.6MHz;
			37578 pbar RW v8, 2nd step RW 0.7MHz;
			37579 pbar RW v8, 2nd step RW 0.8MHz;
			37580 pbar RW v8, 2nd step RW 0.9MHz             hD 3926 cD 2749 r(59 103);

			37581 pbar RW v8, 2nd step RW 0.1MHz             hD 3107 cD 3077 r(62 190);
			37582 pbar RW v8, 2nd step RW 0.3MHz             hD 4310 cD 2449 r(54  84);
			37583 pbar RW v8, 2nd step RW 0.3MHz, flag3      hD 3355 cD 3111 r(45 100);

			37584 pbar RW v8, RW 74s 0.3MHz ; 9+6.5s 0.5MHz, flag3 "no pbar";
			37585 pbar RW v8, RW 74s 0.3MHz ; 9+6.5s 0.5MHz, flag3 "no pbar";
			37586 pbar RW v8, RW 74s 0.3MHz ; 9+6.5s 0.5MHz, flag3;

			37595 pbar RW v8, RW 30s 0.3MHz ; 53+6.5s 0.7MHz    hD 3764 cD 3095 r(33  72) ;
			37596 pbar RW v8, RW 40s 0.3MHz ; 43+6.5s 0.7MHz    hD 3887 cD 2977 r(34  75);
			37597 pbar RW v8, RW 40s 0.3MHz ; 43+6.5s 1.0MHz    hD 3781 cD 3199 r(29 134);
			</p>

		</body>
<html>

