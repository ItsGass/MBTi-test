<?php

namespace Database\Seeders;

use App\Enums\Dimension;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Forty items, ten per dimension, split five positive and five negative so
     * that agreeing with every statement cannot tilt a dimension.
     *
     * `direction` +1 pushes toward the left pole (E, S, T, J); -1 pushes toward
     * the right pole (I, N, F, P). Every item carries three interchangeable
     * phrasings; only one is shown per attempt.
     *
     * @return array<int, array{dimension: string, direction: int, variants: array<int, string>}>
     */
    private function questions(): array
    {
        return [
            // Extraversion
            ['dimension' => 'EI', 'direction' => 1, 'variants' => [
                'Saya merasa berenergi setelah menghabiskan waktu bersama banyak orang.',
                'Berada di tengah banyak orang justru membuat energi saya bertambah.',
                'Setelah berkumpul dengan banyak orang, saya merasa lebih segar dan bersemangat.',
            ]],
            ['dimension' => 'EI', 'direction' => 1, 'variants' => [
                'Saya suka memulai obrolan dengan orang yang baru dikenal.',
                'Saya tidak ragu menyapa dan membuka percakapan dengan orang baru.',
                'Menjadi orang pertama yang menyapa seseorang yang belum saya kenal itu menyenangkan.',
            ]],
            ['dimension' => 'EI', 'direction' => 1, 'variants' => [
                'Saya sering berbicara sebelum memikirkan kata-kata dengan matang.',
                'Saya cenderung mengutarakan pikiran langsung, kadang sebelum benar-benar dipikirkan.',
                'Saya lebih suka bicara spontan daripada menyusun kalimat di kepala lebih dulu.',
            ]],
            ['dimension' => 'EI', 'direction' => 1, 'variants' => [
                'Saya merasa bosan jika terlalu lama berada di ruangan sendiri tanpa interaksi.',
                'Terlalu lama sendirian tanpa mengobrol dengan siapa pun membuat saya gelisah.',
                'Saya butuh interaksi; kalau terlalu lama menyendiri, saya cepat bosan.',
            ]],
            ['dimension' => 'EI', 'direction' => 1, 'variants' => [
                'Saya mudah beradaptasi dan bersosialisasi dalam lingkungan baru.',
                'Di tempat yang baru, saya cepat akrab dengan orang-orang di sekitar.',
                'Saya bisa dengan mudah menyesuaikan diri dan mulai mengobrol di lingkungan baru.',
            ]],
            ['dimension' => 'EI', 'direction' => -1, 'variants' => [
                'Saya lebih nyaman menghabiskan waktu sendiri daripada dalam keramaian.',
                'Waktu sendiri terasa lebih nyaman bagi saya dibanding suasana ramai.',
                'Saya memilih suasana tenang dan menyendiri daripada keramaian yang padat.',
            ]],
            ['dimension' => 'EI', 'direction' => -1, 'variants' => [
                'Saya perlu waktu sendirian untuk mengisi kembali energi setelah beraktivitas sosial.',
                'Setelah banyak berinteraksi, saya butuh waktu sendiri untuk memulihkan energi.',
                'Bagi saya, menyendiri sebentar adalah cara mengisi ulang tenaga setelah bersosialisasi.',
            ]],
            ['dimension' => 'EI', 'direction' => -1, 'variants' => [
                'Saya lebih suka mendengarkan daripada bicara dalam kelompok besar.',
                'Dalam diskusi kelompok besar, saya lebih banyak menyimak daripada berbicara.',
                'Saya merasa lebih nyaman menjadi pendengar di tengah percakapan kelompok yang ramai.',
            ]],
            ['dimension' => 'EI', 'direction' => -1, 'variants' => [
                'Saya memilih memiliki sedikit teman dekat daripada banyak teman kenal.',
                'Saya lebih suka lingkaran pertemanan kecil yang dekat daripada banyak kenalan.',
                'Bagi saya, beberapa sahabat dekat lebih berharga daripada banyak teman yang sekadar kenal.',
            ]],
            ['dimension' => 'EI', 'direction' => -1, 'variants' => [
                'Saya butuh waktu untuk memikirkan jawaban sebelum ikut berbicara di forum.',
                'Dalam sebuah forum, saya biasanya memproses dulu di kepala sebelum menyampaikan pendapat.',
                'Saya lebih nyaman menyusun pemikiran sendiri dulu sebelum bicara di depan banyak orang.',
            ]],

            // Sensing / Intuition
            ['dimension' => 'SN', 'direction' => 1, 'variants' => [
                'Saya lebih tertarik pada detail yang konkret dan dapat terlihat langsung.',
                'Saya lebih mudah tertarik pada hal yang nyata dan bisa saya lihat langsung.',
                'Detail yang jelas dan konkret lebih menarik perhatian saya daripada hal yang masih samar.',
            ]],
            ['dimension' => 'SN', 'direction' => 1, 'variants' => [
                'Saya percaya pada pengalaman langsung dan fakta yang dapat diverifikasi.',
                'Bagi saya, pengalaman nyata dan fakta yang bisa dicek adalah pegangan utama.',
                'Saya lebih percaya pada apa yang sudah terbukti lewat pengalaman dan data nyata.',
            ]],
            ['dimension' => 'SN', 'direction' => 1, 'variants' => [
                'Saya menyukai instruksi yang langkah demi langkah dan spesifik.',
                'Saya lebih suka petunjuk yang rinci dan berurutan saat mengerjakan sesuatu.',
                'Langkah-langkah yang spesifik membuat saya lebih yakin dalam mengerjakan tugas.',
            ]],
            ['dimension' => 'SN', 'direction' => 1, 'variants' => [
                'Saya lebih fokus pada apa yang nyata sekarang daripada apa yang mungkin akan terjadi.',
                'Saya lebih memikirkan keadaan saat ini daripada membayangkan kemungkinan di masa depan.',
                'Realitas yang terjadi sekarang lebih penting bagi saya dibanding skenario yang mungkin terjadi.',
            ]],
            ['dimension' => 'SN', 'direction' => 1, 'variants' => [
                'Saya suka menyelesaikan masalah dengan pendekatan praktis dan langsung.',
                'Saat ada masalah, saya mencari solusi praktis yang bisa langsung diterapkan.',
                'Saya lebih suka menangani masalah secara langsung dan praktis daripada berteori panjang.',
            ]],
            ['dimension' => 'SN', 'direction' => -1, 'variants' => [
                'Saya lebih tertarik pada kemungkinan dan ide masa depan daripada detail yang sudah terlihat.',
                'Kemungkinan di masa depan lebih menarik bagi saya daripada detail yang tampak sekarang.',
                'Saya lebih suka membayangkan peluang baru daripada berkutat pada hal yang sudah jelas.',
            ]],
            ['dimension' => 'SN', 'direction' => -1, 'variants' => [
                'Saya sering membayangkan bagaimana sesuatu bisa berkembang di masa depan.',
                'Saya mudah terbayang ke mana sesuatu akan berkembang nanti.',
                'Pikiran saya sering melayang ke kemungkinan-kemungkinan yang bisa terjadi di kemudian hari.',
            ]],
            ['dimension' => 'SN', 'direction' => -1, 'variants' => [
                'Saya suka mengeksplorasi ide-ide abstrak yang belum ada wujudnya.',
                'Saya senang membahas gagasan abstrak yang belum punya bentuk nyata.',
                'Ide-ide besar dan belum terwujud justru membuat saya penasaran untuk mengeksplorasinya.',
            ]],
            ['dimension' => 'SN', 'direction' => -1, 'variants' => [
                'Saya mencari pola dan arti di balik informasi yang saya terima.',
                'Saya cenderung menghubungkan informasi untuk menemukan pola dan makna di baliknya.',
                'Bagi saya, data mentah baru bermakna setelah saya temukan pola di dalamnya.',
            ]],
            ['dimension' => 'SN', 'direction' => -1, 'variants' => [
                'Saya lebih suka membahas konsep dan kemungkinan daripada hal teknis yang rinci.',
                'Saya lebih menikmati percakapan tentang gagasan besar daripada detail teknis.',
                'Diskusi soal konsep dan visi terasa lebih menarik bagi saya dibanding urusan teknis yang mendetail.',
            ]],

            // Thinking / Feeling
            ['dimension' => 'TF', 'direction' => 1, 'variants' => [
                'Saat mengambil keputusan, saya mempertimbangkan konsistensi logika dan alasan yang objektif.',
                'Saya memutuskan berdasarkan alasan yang logis dan bisa dipertanggungjawabkan.',
                'Dalam mengambil keputusan, logika dan objektivitas menjadi pertimbangan utama saya.',
            ]],
            ['dimension' => 'TF', 'direction' => 1, 'variants' => [
                'Saya lebih peduli pada keadilan dan kesetaraan daripada kesetiaan pribadi.',
                'Bagi saya, keadilan yang merata lebih penting daripada loyalitas pada orang tertentu.',
                'Saya memilih bersikap adil untuk semua orang meskipun itu berarti tidak membela teman sendiri.',
            ]],
            ['dimension' => 'TF', 'direction' => 1, 'variants' => [
                'Saya dapat memberikan kritik konstruktif meskipun membuat orang lain merasa tidak nyaman.',
                'Saya tetap menyampaikan kritik yang membangun walau lawan bicara bisa tersinggung.',
                'Menyampaikan koreksi yang jujur lebih penting bagi saya daripada menghindari ketidaknyamanan orang lain.',
            ]],
            ['dimension' => 'TF', 'direction' => 1, 'variants' => [
                'Saya suka menganalisis situasi secara objektif sebelum menilai baik atau buruk.',
                'Sebelum menilai sesuatu, saya menganalisisnya dulu secara objektif.',
                'Saya terbiasa mengurai situasi dengan kepala dingin sebelum memberi penilaian.',
            ]],
            ['dimension' => 'TF', 'direction' => 1, 'variants' => [
                'Keputusan yang adil lebih penting bagi saya daripada keputusan yang membuat semua orang senang.',
                'Saya lebih memilih keputusan yang adil meski tidak semua orang menyukainya.',
                'Keadilan dalam keputusan lebih saya utamakan daripada menyenangkan semua pihak.',
            ]],
            ['dimension' => 'TF', 'direction' => -1, 'variants' => [
                'Saat mengambil keputusan, saya mempertimbangkan dampak terhadap perasaan orang lain.',
                'Saya memikirkan bagaimana keputusan saya akan memengaruhi perasaan orang di sekitar.',
                'Dampak emosional pada orang lain selalu masuk pertimbangan saat saya memutuskan sesuatu.',
            ]],
            ['dimension' => 'TF', 'direction' => -1, 'variants' => [
                'Saya cenderung menghindari konflik untuk menjaga harmoni hubungan.',
                'Saya berusaha menahan diri agar hubungan tetap harmonis dan bebas konflik.',
                'Menjaga kedamaian hubungan lebih penting bagi saya daripada memenangkan perdebatan.',
            ]],
            ['dimension' => 'TF', 'direction' => -1, 'variants' => [
                'Saya mempertimbangkan nilai-nilai pribadi saat membuat keputusan penting.',
                'Keputusan besar bagi saya harus sejalan dengan nilai yang saya pegang.',
                'Saya menimbang apakah pilihan saya sesuai dengan prinsip dan nilai pribadi saya.',
            ]],
            ['dimension' => 'TF', 'direction' => -1, 'variants' => [
                'Saya lebih memperhatikan emosi dan kebutuhan emosional dalam tim.',
                'Dalam sebuah tim, saya peka terhadap suasana hati dan kebutuhan emosional anggotanya.',
                'Saya cenderung memperhatikan perasaan orang di tim, bukan hanya target kerja.',
            ]],
            ['dimension' => 'TF', 'direction' => -1, 'variants' => [
                'Saya lebih mudah tergerak oleh cerita dan pengalaman orang lain daripada data.',
                'Kisah dan pengalaman pribadi orang lain lebih menyentuh saya dibanding angka dan statistik.',
                'Saya lebih cepat memahami sesuatu lewat cerita seseorang daripada lewat data.',
            ]],

            // Judging / Perceiving
            ['dimension' => 'JP', 'direction' => 1, 'variants' => [
                'Saya lebih nyaman ketika kegiatan sudah memiliki rencana yang jelas.',
                'Rencana yang sudah tersusun membuat saya merasa lebih tenang.',
                'Saya lebih menikmati aktivitas yang sudah jelas arah dan susunannya.',
            ]],
            ['dimension' => 'JP', 'direction' => 1, 'variants' => [
                'Saya suka menyelesaikan tugas sebelum tenggat mendekat.',
                'Saya berusaha menuntaskan pekerjaan jauh sebelum batas waktunya.',
                'Menunda pekerjaan sampai mepet tenggat bukan gaya saya.',
            ]],
            ['dimension' => 'JP', 'direction' => 1, 'variants' => [
                'Saya membuat daftar tugas dan mencoba mengikutinya dengan disiplin.',
                'Saya terbiasa mencatat tugas lalu mengerjakannya sesuai daftar.',
                'To-do list membantu saya tetap disiplin menyelesaikan hal satu per satu.',
            ]],
            ['dimension' => 'JP', 'direction' => 1, 'variants' => [
                'Saya ingin segala sesuatu selesai dan tertib sebelum beralih ke hal baru.',
                'Saya lebih nyaman merapikan dan menuntaskan satu hal sebelum pindah ke hal lain.',
                'Meninggalkan pekerjaan setengah jadi membuat saya kurang tenang.',
            ]],
            ['dimension' => 'JP', 'direction' => 1, 'variants' => [
                'Saya merasa nyaman ketika hal-hal teratur dan terjadwal dengan jelas.',
                'Jadwal yang rapi dan teratur membuat saya merasa nyaman.',
                'Keteraturan dan jadwal yang jelas adalah suasana yang paling saya sukai.',
            ]],
            ['dimension' => 'JP', 'direction' => -1, 'variants' => [
                'Saya suka kesempatan dan kesediaan untuk mengubah rencana kapan saja.',
                'Saya menyukai keleluasaan untuk mengubah rencana secara mendadak.',
                'Rencana yang bisa berubah kapan saja justru terasa menyenangkan bagi saya.',
            ]],
            ['dimension' => 'JP', 'direction' => -1, 'variants' => [
                'Saya sering menunda tugas hingga waktu mendesak baru menyelesaikannya.',
                'Saya cenderung mengerjakan tugas saat tenggat sudah benar-benar dekat.',
                'Tekanan waktu yang mendesak justru sering jadi pemicu saya menyelesaikan tugas.',
            ]],
            ['dimension' => 'JP', 'direction' => -1, 'variants' => [
                'Saya merasa terbatas dengan jadwal yang terlalu kaku dan terstruktur.',
                'Jadwal yang kaku membuat saya merasa terkekang.',
                'Saya lebih nyaman tanpa jadwal yang terlalu ketat dan terstruktur.',
            ]],
            ['dimension' => 'JP', 'direction' => -1, 'variants' => [
                'Saya suka membuka pilihan sebanyak mungkin sebelum membuat keputusan final.',
                'Saya lebih suka menahan keputusan sampai semua pilihan terbuka lebar.',
                'Menjaga banyak opsi tetap terbuka membuat saya lebih nyaman sebelum memilih.',
            ]],
            ['dimension' => 'JP', 'direction' => -1, 'variants' => [
                'Saya lebih suka menyesuaikan diri dengan situasi daripada mengikuti rencana yang sudah tetap.',
                'Saya fleksibel mengikuti apa yang terjadi, daripada terpaku pada rencana awal.',
                'Menyesuaikan langkah dengan keadaan saat itu terasa lebih alami bagi saya.',
            ]],
        ];
    }

    public function run(): void
    {
        $questions = $this->questions();

        foreach ($questions as $index => $entry) {
            $question = Question::updateOrCreate(
                ['sort_order' => $index + 1],
                [
                    'dimension' => Dimension::from($entry['dimension']),
                    'direction' => $entry['direction'],
                    'is_active' => true,
                ]
            );

            $question->variants()->whereNotIn('text', $entry['variants'])->delete();

            foreach ($entry['variants'] as $text) {
                $question->variants()->updateOrCreate(
                    ['text' => $text],
                    ['is_active' => true]
                );
            }
        }

        Question::query()
            ->where('sort_order', '>', count($questions))
            ->update(['is_active' => false]);
    }
}
