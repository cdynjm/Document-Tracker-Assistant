@php
    use App\Models\Tracker;

    // Fetch all trackers and group by `docType`
    $trackerData = Tracker::whereIn('docType', $documentCount->pluck('docType'))
        ->where('sectionID', auth()->user()->sectionID)
        ->get()
        ->groupBy('docType');

    $count = 0;

    // Loop through documents and count matching trackers
    foreach ($documentCount as $doc) {
        if (isset($trackerData[$doc->docType])) {
            foreach ($trackerData[$doc->docType] as $tracker) {
                if ($tracker->trackerID == $doc->trackerID) {
                    $count++;
                }
            }
        }
    }

   /* $trackerDataNull = Tracker::whereIn('docType', $documents->pluck('docType'))
        ->where('sectionID', null)
        ->get()
        ->groupBy('docType');

   

    // Loop through documents and count matching trackers
    foreach ($documents as $doc) {
        if (isset($trackerDataNull[$doc->docType])) {
            foreach ($trackerDataNull[$doc->docType] as $tracker) {
                if ($tracker->trackerID == $doc->trackerID) {
                    if($doc->officeID == Auth::user()->Section->Office->id && 
                    collect(['receiving', 'receive', 'receiver', 'recieving', 'reciever', 'recieve'])
                        ->contains(fn($word) => \Str::contains(strtolower(Auth::user()->Section->section), $word)) 
                    )   {
                            $count++;
                        }
                }
            }
        }
    } */
@endphp

<span class="count-data-result" data-id="{{ $dataID }}">
    @if ($count > 0)
        <span class="badge bg-danger">
            {{ $count }}
        </span>
    @endif
</span>
