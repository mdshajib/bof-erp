<html>
<head>
<style>
    .modal{
        display: none;
    }
</style>
</head>
<body>
<button type="button" onclick='printReceipt("print")'>Click</button>
<div class="modal">
    <div id="print">
        @include('livewire.order.receipt_order')
    </div>
</div>
<script>
    function printReceipt(el){
        let data = '';
        console.log(el);
        data += '<input type="button" id="printPageButton " class="" style="display: block; width: 100%;border: none;background-color: #1d7f58;padding: 10px;text-align: center;cursor: pointer;font-size: 14px;" value="Print" onClick="window.print()">';
        data += document.getElementById(el).innerHTML;
        var myReceipt = window.open("", "myWin", "left=250,top=170,height=400,width=300");
        myReceipt.screenX = 0;
        myReceipt.screenY = 0;
        myReceipt.document.write(data);
        myReceipt.document.title = 'Print';
        myReceipt.focus();

        // setTimeout(() => {
        //     myReceipt.close();
        // }, 1000);

    }
</script>
</body>
</html>
