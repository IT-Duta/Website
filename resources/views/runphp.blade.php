
<?php


header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=student_list.xls");
header("Pragma: no-cache");
header("Expires: 0");

$hostname = "192.168.101.223/3051:F:\\FINA\LG\LG2021.FDB";
$user = "SYSDBA";
$password = "masterkey";

$conn = ibase_connect( $hostname, $user, $password ) or die( 'Error: ' . ibase_errmsg() );

//$Arr_Dados = array();

$query = "SELECT a.GLHISTID as GL
, a.SEQ
, replace(a.TRANSDATE,'.','/') TRANSDATE

--- Query ambil Modul Transaksi --------------------

, iif (((a.SOURCE = 'AP') and (a.TRANSTYPE = 'INV')), 'Purchase Invoice'
, iif(((a.SOURCE = 'CH') and (a.TRANSTYPE = 'PUR')), 'Cash Purchase'
, iif(((a.SOURCE = 'AP') and (a.TRANSTYPE = 'RCV')), 'Receive Items'
, iif(((a.SOURCE = 'AP') and (a.TRANSTYPE = 'ORD')), 'Purchase Order'
, iif(((a.SOURCE = 'AP') and (a.TRANSTYPE = 'CHQ')), 'Vendor Payment'
, iif(((a.SOURCE = 'AP') and (a.TRANSTYPE = 'RTR')), 'Purchase Return'
, iif(((a.SOURCE = 'AR') and (a.TRANSTYPE = 'INV')), 'Sales Invoice'
, iif(((a.SOURCE = 'CH') and (a.TRANSTYPE = 'SLS')), 'Cash Sales'
, iif(((a.SOURCE = 'AR') and (a.TRANSTYPE = 'DLV')), 'Delivery Order'
, iif(((a.SOURCE = 'AR') and (a.TRANSTYPE = 'ORD')), 'Sales Order'
, iif(((a.SOURCE = 'AR') and (a.TRANSTYPE = 'PMT')), 'Customer Receipt'
, iif(((a.SOURCE = 'AR') and (a.TRANSTYPE = 'RTR')), 'Sales Return'
, iif(((a.SOURCE = 'GL') and (a.TRANSTYPE = 'JV')), 'Journal Voucher'
, iif(((a.SOURCE = 'GL') and (a.TRANSTYPE = 'PMT')), 'Other Payment'
, iif(((a.SOURCE = 'GL') and (a.TRANSTYPE = 'DPT')), 'Other Deposit'
, iif(((a.SOURCE = 'FA') and (a.TRANSTYPE = 'ACQ')), 'FA Acquisition'
, iif(((a.SOURCE = 'FA') and (a.TRANSTYPE = 'DIS')), 'FA Disposed'
, iif(((a.SOURCE = 'IT') and (a.TRANSTYPE = 'ADJ')), 'Inventory Adjustment'
, iif(((a.SOURCE = 'PR') and (a.TRANSTYPE = 'JOB')), 'Job Costing'
, iif(((a.SOURCE = 'PD') and (a.TRANSTYPE = 'MR')), 'Material Release'
, iif(((a.SOURCE = 'PD') and (a.TRANSTYPE = 'RES')), 'Product And Material Result',''))))))))))))))))))))) Transaction_Type

-------------------------------------------------------

,g.SOURCENO

--- Query ambil Type Transaksi --------------------

,iif ( b.ACCOUNTTYPE=7 , 'Cash/Bank'
,iif ( b.ACCOUNTTYPE=8 , 'Account Receivable'
,iif ( b.ACCOUNTTYPE=9 , 'Inventory'
,iif ( b.ACCOUNTTYPE=10 , 'Other Current Asset'
,iif ( b.ACCOUNTTYPE=11 , 'Fixed Asset'
,iif ( b.ACCOUNTTYPE=12 , 'Accumulated Depreciation'
,iif ( b.ACCOUNTTYPE=13 , 'Account Payable'
,iif ( b.ACCOUNTTYPE=14 , 'Other Current Liability'
,iif ( b.ACCOUNTTYPE=15 , 'Long Term Liability'
,iif ( b.ACCOUNTTYPE=16 , 'Equity'
,iif ( b.ACCOUNTTYPE=17 , 'Revenue'
,iif ( b.ACCOUNTTYPE=18 , 'Cost of Goods Sold'
,iif ( b.ACCOUNTTYPE=19 , 'Expense'
,iif ( b.ACCOUNTTYPE=20 , 'Other Expense'
,iif ( b.ACCOUNTTYPE=21 , 'Other Income',''))))))))))))))) Account_Type

-------------------------------------------------------

,a.GLACCOUNT
,b.ACCOUNTNAME
,replace(g.BDEBIT,'.',',') BDEBIT
,replace(g.BCREDIT,'.',',') BCREDIT
,coalesce (X.DEPTNO,'-') DEPTNO
,coalesce (Y.PROJECTNO,'-') PROJECTNO
,coalesce (Y.PROJECTNAME,'-') PROJECTNAME
,replace(replace(a.TRANSDESCRIPTION,'
',' '),'    ',' ') TRANSDESCRIPTION
,replace((coalesce (Y.DESCRIPTION,'-')),'
',' ') despro
, replace((iif (p.PERSONTYPE='0',g.NAME,'-')),'
',' ') Customer
, replace((iif (p.PERSONTYPE='1',g.NAME,'-')),'
',' ') Vendor
,coalesce (g.INVOICENO,'-') No_Invoice
,(select c.COUNTRY from COMPANY c) Db

FROM GLHIST a
INNER JOIN GLACCNT b on b.GLACCOUNT = a.GLACCOUNT
LEFT OUTER JOIN GET_SOURCENO(a.GLHISTID,a.INVOICEID,a.FASSETID,a.TRANSTYPE,a.SOURCE,a.Seq, 1) g on a.GLHISTID=g.GLHISTID
left outer join PERSONDATA p on p.ID = g.PERSONID
left outer join DEPARTMENT X on X.DEPTID=a.DEPTID
left outer join PROJECT Y on Y.PROJECTID=a.PROJECTID

where extract (year from a.TRANSDATE)= '2021'
ORDER BY a.GLACCOUNT, a.TRANSDATE";
// $query = "SELECT * FROM ITEM I inner join
// ITEMBALANCE IB
// ON IB.ITEMNO = I.ITEMNO
// ";
$run_query = ibase_query( $query );


	$output = "";

	$output .="
		<table>
			<thead>
				<tr>
                    <th>GLHISTID</th>
                    <th>SEQ</th>
                    <th>Date</th>
                    <th>Transaction_Type</th>
                    <th>Transaction_Number</th>
                    <th>Account_Type</th>
                    <th>Account_Number</th>
                    <th>Account_Name</th>
                    <th>_Debit_</th>
                    <th>_Credit_</th>
                    <th>Department</th>
                    <th>Project_Number</th>
                    <th>Project_Name</th>
                    <th>Transaction_Description</th>
                    <th>Description_Project</th>
                    <th>Customer</th>
                    <th>Vendor</th>
                    <th>No_Invoice</th>
                    <th>Database</th>
				</tr>
			<tbody>
	";


	while($fetch = ibase_fetch_assoc( $run_query )){

	$output .= "
				<tr>
                    <td>".$fetch['GL']."</td>
            <td>".$fetch['SEQ']."</td>
            <td>".$fetch['TRANSDATE']."</td>
            <td>".$fetch['TRANSACTION_TYPE']."</td>
            <td>".$fetch['SOURCENO']."</td>
            <td>".$fetch['ACCOUNT_TYPE']."</td>
            <td>".$fetch['GLACCOUNT']."</td>
            <td>".$fetch['ACCOUNTNAME']."</td>
            <td>".$fetch['BDEBIT']."</td>
            <td>".$fetch['BCREDIT']."</td>
            <td>".$fetch['DEPTNO']."</td>
            <td>".$fetch['PROJECTNO']."</td>
            <td>".$fetch['PROJECTNAME']."</td>
            <td>".$fetch['TRANSDESCRIPTION']."</td>
            <td>".$fetch['DESPRO']."</td>
            <td>".$fetch['CUSTOMER']."</td>
            <td>".$fetch['VENDOR']."</td>
            <td>".$fetch['NO_INVOICE']."</td>
            <td>".$fetch['DB']."</td>
				</tr>
	";
	}

	$output .="
			</tbody>

		</table>
	";

	echo $output;


?>
