<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
   // 1. បង្ហាញបញ្ជីបន្ទប់ + មុខងារ Search & Filter
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $rooms = Room::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('room_id', 'LIKE', "%{$search}%")
                      ->orWhere('room_name', 'LIKE', "%{$search}%");
                });
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->orderBy('room_id', 'asc')
            ->paginate(10) // ធ្វើការបែងចែកទំព័រ (Pagination)
            ->withQueryString(); // រក្សាតម្លៃ Search/Filter នៅពេលប្តូរទំព័រ

        return view('admin.room.index', compact('rooms'));
    }

    // 2. ផ្ទាំងបង្កើតថ្មី
    public function create()
    {
        return view('admin.room.create');
    }

    // 3. រក្សាទុកទិន្នន័យ
    public function store(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|string|max:10|unique:rooms,room_id',
            'room_name' => 'required|string|max:50',
            'type'      => 'required|string',
            'capacity'  => 'required|integer|min:1',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'បានបង្កើតបន្ទប់រៀនថ្មីជោគជ័យ!');
    }

    // 4. ផ្ទាំងកែប្រែ
    public function edit(Room $room)
    {
        return view('admin.room.edit', compact('room'));
    }

    // 5. ធ្វើបច្ចុប្បន្នភាពទិន្នន័យ
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_name' => 'required|string|max:50',
            'type'      => 'required|string',
            'capacity'  => 'required|integer|min:1',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'បានកែប្រែព័ត៌មានបន្ទប់ជោគជ័យ!');
    }

    // 6. លុបទិន្នន័យ
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'បានលុບບន្ទប់រៀនជោគជ័យ!');
    }
}
