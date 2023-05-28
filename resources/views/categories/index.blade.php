<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('categories') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg" style="
            padding: 1%;">
                <h2>Categories</h1>
                <div class="row" id="images_div">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                foreach ($categories as $category) {
                                    echo '<p class="card-text"> - ' . $category->name . '</p>';
                                    foreach ($category->children as $subcategory) {
                                        echo '<p class="card-text"> -- ' . $subcategory->name . '</p>';
                                        foreach ($subcategory->subCategories as $sub2) {
                                            echo '<p class="card-text"> --- ' . $sub2->name . '</p>';
                                            foreach ($sub2->subCategories as $sub3) {
                                                echo '<p class="card-text"> ---- ' . $sub3->name . '</p>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
