<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection ,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::where('role', 1)->get();
        
        $data = collect();

        foreach ($users as $key => $user) {
            $s_no        = $key + 1;
            $status     = $user->status == 1 ? 'Active' : 'Inactive';
            $full_name  = $user->first_name . ' ' . $user->last_name;
            $subscriber = $user->status == 1 ? 'Free Subscriber' : 'Free Subscriber';
        
            $userData = [
                'S.No'       => $s_no,
                'Full Name'  => $full_name,
                'Email'      => $user->email,
                'Subscriber' => $subscriber,
                'Status'     => $status,
            ];
        
            // Add user data to the main data array
            $data->push($userData);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Full Name',
            'Email',
            'Subscriber',
            'Status',
        ];
    }
}
