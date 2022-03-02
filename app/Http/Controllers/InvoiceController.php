<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\InvoiceEmail;
use App\Jobs\InvoiceEmailJob;
use App\Models\Task;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * function index
     * display invoice
    */
    public function index(Request $request)
    {
        $invoices = Invoice::with('client')->latest();

        if(!empty($request->client_id)){
            $invoices = $invoices->where('client_id', $request->client_id);
        }

        if(!empty($request->status)){
            $invoices = $invoices->where('status', $request->status);
        }
        if(!empty($request->emailsent)){
            $invoices = $invoices->where('email_sent', $request->emailsent);
        }

        $invoices = $invoices->paginate(10);
        return view('invoice.index')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'invoices'=> $invoices,
        ]);
    }
     /**
     * function Create
     * @param request
     * Method Get
     * search query
     *
    */
    public function create(Request $request)
    {
        $tasks = false;
        //if client id and status is not empty
        if(!empty($request->client_id) && !empty($request->status)){
            $request->validate([
                'client_id' => ['required','not_in:none'],
                'status' => ['required','not_in:none'],
            ]);
             $tasks = $this->getInvoiceData($request);
        }
        //return
       return view('invoice.create')->with([
           'clients' =>Client::where('user_id',Auth::user()->id)->get(),
           'tasks' =>$tasks ,
       ]);
    }
    /**
     * Mthod Update
     * @param request
     * @param Invoice $invoice
     * @param void
     *
    */
    public function update(Invoice $invoice,Request $request)
    {
        $invoice->update([
            'status' => 'paid'
        ]);
        return redirect()->route('invoice.index')->with('success','Invoice Payment mark as paid');
    }
    /**
     * Mthod Destroy
     * @param Invoice $invoice
     * @param void
     *
    */
    public function destroy(Invoice $invoice)
    {
       Storage::delete('public/invoices/'.$invoice->download_url);
       $invoice->delete();
       return redirect()->route('invoice.index')->with('success','Invoice Deleted');
    }
    /**
     * Method getInvoiceData
     *
     * @param Request $request
     *
     * @return void
     */
    public function getInvoiceData(Request $request)
    {
        $tasks = Task::latest();
        if(!empty($request->client_id)){
            $tasks = $tasks->where('client_id', '=' , $request->client_id);
        }
        if(!empty($request->status)){
            $tasks = $tasks->where('status', '=' , $request->status);
        }
        if(!empty($request->fromDate)){
            $tasks = $tasks->whereDate('created_at', '>=' , $request->fromDate);
        }
        if(!empty($request->endDate)){
            $tasks = $tasks->whereDate('created_at', '<=' , $request->endDate);
        }
        return $tasks->get();

    }
    /**
     * Method preview
     *
     * @param Request $request
     *
     * @return void
     */
    public function preview(Request $request)
    {
    }
    /**
     * Method invoice
     *
     * @param Request $request
     *
     * @return void
     */
    public function invoice(Request $request){
        if (!empty($request->generate) && $request->generate == 'yes'){
            $this->generate($request);
            return redirect()->route('invoice.index')->with('success','Invoice Created');
        }
        if (!empty($request->preview) && $request->preview == 'yes'){
            $tasks = Task::whereIn('id', $request->invoice_ids)->get();
            return view('invoice.preview')->with([
                'invoice_no' => 'INVO_'.rand(255,255555),
                'user' => Auth::user(),
                'tasks' => $tasks,
            ]);
        }
    }
    /**
     * Method generate
     *
     * @param Request $request
     *
     * @return void
     */
    public function generate(Request $request)
    {
            // get tasks from request ids
            $tasks = Task::whereIn('id', $request->invoice_ids)->get();
            $invo_no ='INVO_'.rand(255,255555);
            $data =[
                'invoice_no' =>$invo_no ,
                'user' => Auth::user(),
                'tasks' => $tasks,
            ];

          //Generation PDF
            $pdf = PDF::loadView('invoice.pdf', $data);
              //storage pdf in storage
            Storage::put('public/invoice/'.$invo_no. '.pdf', $pdf->output());

            //Insert Invoice data
            Invoice::create([
                'invoice_id' => $invo_no,
                'client_id' => $tasks->first()->client->id,
                'user_id'  => Auth::user()->id,
                'status'   => 'unpaid',
                'download_url' => $invo_no. '.pdf',
            ]);


    }
    public function sendEmail(Invoice $invoice)
    {
         //$pdf = Storage::get('public/invoice/'.$invoice->download_url);

        $data = [
            'user' => Auth::user(),
            'invoice_id' => $invoice->invoice_id,
            'invoice' => $invoice,
            // 'pdf'   =>$pdf
        ];

        //InvoiceEmailJob::dispatch($data);
        dispatch(new InvoiceEmailJob($data));

    //    Mail::send('emails.invoice', $data ,function($message) use($invoice,$pdf) {
    //        $message->from(Auth::user()->email, Auth::user()->name);
    //        $message->to($invoice->client->email, $invoice->client->name);
    //        $message->subject('Sajib Corp-' .$invoice->invoice_id);
    //        $message->attachData($pdf,$invoice->download_url,[
    //            'mime' => 'application/pdf'
    //        ]);
    //    });
       $invoice->update([
           'email_sent' => 'yes'
       ]);
       return redirect()->route('invoice.index')->with('success','Email Send');
   }

}



