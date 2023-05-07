<html>

<body>

<div class="container">


    <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;border-radius:4px 4px 0 0;max-width:600px;">
        <table class="performance-table" cellpadding="0" cellspacing="0">
            <tbody class="performance-report-tbody">
            @foreach($data as $item)
                <tr>
                    <td class="performance-body">
                        <label for="name">Slug:</label>
                    </td>
                    <td class="performance-body">
                        <input type="text" value="{{$item['slug']}}" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="performance-body">
                        <label for="name">Link:</label>
                    </td>
                    <td class="performance-body">
                        <input type="text" value="{{$item['link']}}" disabled>
                    </td>
                </tr>
                <tr>
                    <td class="performance-body">
                        <label for="name">Visit Count:</label>
                    </td>
                    <td class="performance-body">
                        <input type="text" value="{{$item['visit_count']}}" disabled>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</div>
</body>


<style>

    body {
        margin: 0;
        padding: 0;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }

    img {
        border: 0;
        height: auto;
        line-height: 100%;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
    }

    .p-disabled {
        cursor: default;
        background-color: rgba(239, 239, 239, 0.3);
        color: rgb(84, 84, 84);
        border-color: rgba(118, 118, 118, 0.3);
    }

    /* Style inputs with type="text", select elements and textareas */
    input[type=text], select, textarea, .p-disabled {
        width: 100%; /* Full width */
        padding: 12px; /* Some padding */
        border: 1px solid #ccc; /* Gray border */
        border-radius: 4px; /* Rounded borders */
        box-sizing: border-box; /* Make sure that padding and width stays in place */
        margin-top: 6px; /* Add a top margin */
        margin-bottom: 16px; /* Bottom margin */
        resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
    }

    /* Style the submit button with a specific background color etc */
    input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* When moving the mouse over the submit button, add a darker green color */
    input[type=submit]:hover {
        background-color: #45a049;
    }

    /* Add a background color and some padding around the form */
    .container {
        border-radius: 5px;
        background-color: #f3f3f5;;
        padding: 20px;
    }

    .performance-table {
        border: 0;
        text-align: center;
        background-color: #ffffff;
        width: 100%;
        border-radius: 4px 4px 0 0;
    }

    .performance-report-tbody > tr > td.performance-logo {
        padding: 10px 25px;
    }

    .performance-report-tbody > tr > td.performance-logo > img {
        border: 0;
        display: block;
        outline: none;
        text-decoration: none;
        height: auto;
        width: 150px;
        font-size: 13px;
    }

    .performance-report-tbody > tr > td.performance-header {
        text-align: center;
        padding: 10px 25px;
    }

    .performance-report-tbody > tr > td.performance-body {
        /*color: #0a6aa1 !important;*/
        padding: 2px 25px;
        font-family: Roboto, Helvetica, Arial, sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 20px;
        text-align: left;
        color: #000000;
    }
</style>

</html>

