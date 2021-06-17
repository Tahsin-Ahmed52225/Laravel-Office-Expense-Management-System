{{-- <!DOCTYPE html> --}}
<html lang="en">
<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body>

    <style>
        body{
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
               /* border: 2px solid black; */
               border-left: 0.02em solid rgb(0, 0, 0);
                border-right: 0;
                border-top: 0.02em solid rgb(0, 0, 0);
                border-bottom: 0;
                border-collapse: collapse;
                text-align: center;
         }
        table td,
        table th {
            text-align: center;
            border-left: 0;
            border-right: 0.01em solid rgb(0, 0, 0);
            border-top: 0;
            border-bottom: 0.01em solid rgb(0, 0, 0);
        }
        img{
            height: 50px;
            width:  200px;
            text-align: center;

        }
    </style>

    <div style="display: flex;">
        <div>
            <img src="{{ public_path("/assets/img/brand/blue.jpg") }}" class="navbar-brand-img" alt="TDG Logo">
        </div>

        <div style="text-align: right"> Date: {{ Carbon\Carbon::now()->format('M d Y') }} </div>
    </div>


    <div class="container-fluid">

        <h1 style="text-align: center; font-size:20px; ">Transaction Record: {{ $year }}</h1>
<hr>
        <table class="table" >
            <thead>
              <tr>
                <th>Name</th>
                <th>Designation </th>
                <th>Deparment</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="new">
               @foreach ( $data as $item)
                     <tr  <?php if($item->type == 0){echo 'style="color:red;"';}?> >

                         <td>
                               {{ $item->name }}
                         </td>
                         <td>
                            {{ $item->designation}}
                         </td>
                         <td>
                            {{ $item->department}}
                         </td>
                         <td>
                            {{ $item->category}}
                         </td>
                         <td>
                            {{ $item->amount}}
                         </td>
                         <td>
                            {{ Carbon\Carbon::parse($item->created_at)->format('M d Y') }}
                         </td>

                     </tr>
               @endforeach
               <tr>
                   <td colspan="2" style="padding-top:50px">
                     <span>Transaction Summary</span>
                   </td>
                   <td colspan="2">
                       <u>Expence Details</u>
                       <div >
                        Office cost  : 100<br>
                        Food cost : 10000 <br>
                        Salary cost : 10000 <br>
                       </div>

                   </td>
                   <td colspan="2">
                       Total Amount Added : {{ $total_gain }}<br>
                       Total Amount Expense {{ $total_expense }}
                       <hr >
                      <div >
                       <span style="font-size: 16px;">Amount Left : <?php echo $total_gain - $total_expense; ?></span>
                      </div>
                       <br>
                   </td>
               </tr>

            </tbody>
          </table>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
</body>
</html>
