<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete("delete from todos");
    }

    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);

        $this->withSession([
            "user" => "Mercys"
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Farel")
            ->assertSeeText("2")
            ->assertSeeText("Zeta");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Mercys"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Mercys"
        ])->post("/todolist", [
            "todo" => "Farel"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "Mercys",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Farel"
                ],
                [
                    "id" => "2",
                    "todo" => "Kurniawan"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }


}