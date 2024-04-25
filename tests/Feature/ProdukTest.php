<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\admin\ProdukController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdukTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    use RefreshDatabase;

    public function test_saveProduk(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('gambar_produk.jpg');

        $requestData = [
            'nama_produk' => 'Test Product',
            'harga_beli_produk' => 10.99,
            'harga_jual_produk' => 19.99,
            'deskripsi_produk' => 'Test description',
            'stok_produk' => 100,
            'kategori_produk' => 1,
            'gambar_produk' => $file,
        ];

        $response = $this->post(route('admin.produk.save'), $requestData);

        $response->assertRedirect(route('admin.produk.list'));
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan');

        $this->assertDatabaseHas('produks', [
            'nama_produk' => 'Test Product',
            'harga_beli_produk' => 10.99,
            'harga_jual_produk' => 19.99,
            'deskripsi_produk' => 'Test description',
            'stok_produk' => 100,
            'kategori_produk_id' => 1,
            'slug' => 'test-product',
        ]);

        Storage::disk('public')->assertExists('img/image_obat/' . $file->hashName());
    }
    public function test_list_produk()
    {
        // Create some dummy data
        $kategoriProduk1 = KategoriProduk::factory()->create();
        $kategoriProduk2 = KategoriProduk::factory()->create();
        $produk1 = Produk::factory()->create();
        $produk2 = Produk::factory()->create();

        // Call the listProduk() method
        $response = $this->get(route('admin.produk.list'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the view contains the kategori_produks and list_produk variables
        $response->assertViewHas('kategori_produks', [$kategoriProduk1, $kategoriProduk2]);
        $response->assertViewHas('list_produk', [$produk1, $produk2]);
    }

    public function test_edit_produk_returns_json_response(): void
    {
        // Arrange
        $id = 1;
        $expectedData = [
            'data_produk' => [
                // Define your expected data here
                
            ],
        ];
        
        // Mock the Produk model
        $mockProduk = $this->createMock(Produk::class);
        $mockProduk->method('join')->willReturnSelf();
        $mockProduk->method('select')->willReturnSelf();
        $mockProduk->method('where')->willReturnSelf();
        $mockProduk->method('first')->willReturn($expectedData['data_produk']);
        
        // Create an instance of the ProdukController
        $produkController = new ProdukController($mockProduk);
        
        // Act
        $response = $produkController->editProduk($id);
        
        // Assert
        $this->assertEquals($expectedData, json_decode($response->getContent()));
    }
}
