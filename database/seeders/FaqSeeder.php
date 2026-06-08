<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'category' => 'contract',
                'order' => 1,
                'question' => '簽約時需要注意哪些合約類型？',
                'answer' => <<<'HTML'
<p>不動產交易主要涉及兩種合約類型：</p>
<ul>
    <li><strong>定金合約（預約合約）：</strong>買賣雙方初步達成交易意向時簽訂，需支付定金（通常為總價的5-10%）。此合約確立買賣雙方的權利義務，規範後續正式合約的簽訂時間。
    </li>
    <li><strong>買賣合約（正式合約）：</strong>完成產權調查、貸款審核等程序後簽訂的正式買賣契約。此合約包含完整的交易條件、付款方式、交屋條件等詳細規定，具有完整的法律效力。
    </li>
</ul>
<p class="note">建議簽約前請專業代書或律師審閱合約內容，確保權益受到保障。</p>
HTML,
            ],
            [
                'category' => 'contract ownership',
                'order' => 2,
                'question' => '購買不動產需要準備哪些文件？',
                'answer' => <<<'HTML'
<p>一般而言，購買不動產需準備以下基本文件：</p>
<ul>
    <li>身分證明文件（身分證或護照）</li>
    <li>印鑑證明與印鑑章</li>
    <li>戶籍謄本</li>
    <li>財力證明（申請貸款時需要）</li>
    <li>收入證明文件（薪資證明、扣繳憑單等）</li>
</ul>
<p class="note">外國人購買不動產另需準備居留證明或入境簽證，詳細規定請洽詢本公司專業顧問。</p>
HTML,
            ],
            [
                'category' => 'tax',
                'order' => 3,
                'question' => '購買不動產需要繳納哪些稅費？',
                'answer' => <<<'HTML'
<p>購買不動產時主要涉及以下稅費：</p>
<ul>
    <li><strong>契稅：</strong>按房地總價的6%計算</li>
    <li><strong>印花稅：</strong>按契價的0.1%計算</li>
    <li><strong>登記規費：</strong>土地與建物分別計算</li>
    <li><strong>代書費：</strong>辦理產權移轉相關費用</li>
    <li><strong>火險與地震險：</strong>申請貸款時需投保</li>
</ul>
<p class="note">實際稅額會因物件類型、地區、價格而有所差異，建議向專業代書或本公司諮詢詳細計算。</p>
HTML,
            ],
            [
                'category' => 'tax',
                'order' => 4,
                'question' => '出售不動產時需要繳納什麼稅？',
                'answer' => <<<'HTML'
<p>出售不動產主要涉及以下稅負：</p>
<ul>
    <li><strong>房地合一稅：</strong>依持有期間與交易所得計算，稅率15%-45%不等</li>
    <li><strong>土地增值稅：</strong>依土地漲價倍數計算，稅率20%-40%</li>
    <li><strong>財產交易所得稅：</strong>部分情況適用，需併入綜合所得稅申報</li>
</ul>
<p class="note">自住房地符合條件者可申請優惠稅率或免稅，詳細規定請諮詢稅務專業人士。</p>
HTML,
            ],
            [
                'category' => 'ownership',
                'order' => 5,
                'question' => '如何計算房屋的實際面積？',
                'answer' => <<<'HTML'
<p>房屋面積的計算方式主要有兩種：</p>
<ul>
    <li><strong>登記面積（權狀面積）：</strong>包含主建物、附屬建物（陽台、雨遮）及共用部分（梯廳、機房等公設）。這是產權登記的正式面積。</li>
    <li><strong>室內實際使用面積：</strong>扣除公設、陽台等，實際可使用的室內空間。一般而言，實際使用面積約為登記面積的60-75%。</li>
</ul>
<p class="note">公設比越高，實際使用面積占比越低。購屋前建議實地丈量確認，或請專業人士協助評估。</p>
HTML,
            ],
            [
                'category' => 'ownership',
                'order' => 6,
                'question' => '外國人可以在台灣購買不動產嗎？',
                'answer' => <<<'HTML'
<p>可以。外國人在台灣購買不動產須符合以下規定：</p>
<ul>
    <li>需取得內政部許可（住宅用途通常可獲准）</li>
    <li>購買土地有面積限制與用途限制</li>
    <li>特定區域（如軍事管制區）禁止外國人購買</li>
    <li>大陸地區人民購買不動產另有特別規定</li>
</ul>
<p class="note">本公司提供外國人購屋專業諮詢服務，協助辦理相關許可申請與產權登記。</p>
HTML,
            ],
            [
                'category' => 'ownership',
                'order' => 7,
                'question' => '不動產產權的有效期限是多久？',
                'answer' => <<<'HTML'
<p>台灣的不動產產權制度說明如下：</p>
<ul>
    <li><strong>土地所有權：</strong>永久產權，無期限限制</li>
    <li><strong>建物所有權：</strong>永久產權，無期限限制</li>
    <li><strong>地上權：</strong>依契約約定年限，期滿可申請續約</li>
</ul>
<p class="note">台灣採土地與建物分別登記制度，購買房屋時請確認土地所有權類型，以保障自身權益。</p>
HTML,
            ],
            [
                'category' => 'finance',
                'order' => 8,
                'question' => '購屋可以申請銀行貸款嗎？最高可貸多少成數？',
                'answer' => <<<'HTML'
<p>可以。台灣購屋貸款的基本資訊如下：</p>
<ul>
    <li><strong>貸款成數：</strong>一般為房價的7-8成，最高可達8.5成（視銀行與個人條件而定）</li>
    <li><strong>貸款年限：</strong>最長可達30-40年</li>
    <li><strong>利率：</strong>目前約在1.8%-2.5%之間（機動計息）</li>
    <li><strong>申請條件：</strong>需有穩定收入、良好信用記錄，負債比不超過月收入的60%</li>
</ul>
<p class="note">本公司配合多家銀行，可協助客戶爭取最優惠的貸款條件與利率。</p>
HTML,
            ],
            [
                'category' => 'finance',
                'order' => 9,
                'question' => '資金如何安全地進出與轉移？',
                'answer' => <<<'HTML'
<p>不動產交易資金移轉建議透過以下安全管道：</p>
<ul>
    <li><strong>銀行匯款：</strong>最安全的轉帳方式，保留完整交易紀錄</li>
    <li><strong>銀行本票：</strong>用於支付定金或簽約款項</li>
    <li><strong>履約保證專戶：</strong>由第三方（銀行或地政士）保管，確保買賣雙方權益</li>
    <li><strong>信託專戶：</strong>適用於預售屋，保障購屋款項安全</li>
</ul>
<p class="note">避免使用現金交易，所有款項往來應保留完整憑證，並依法申報以符合洗錢防制規定。</p>
HTML,
            ],
            [
                'category' => 'finance',
                'order' => 10,
                'question' => '首次購屋有什麼優惠方案嗎？',
                'answer' => <<<'HTML'
<p>首次購屋可享有以下優惠：</p>
<ul>
    <li><strong>青年安心成家購屋優惠貸款：</strong>由政府提供利息補貼，貸款利率較一般房貸優惠</li>
    <li><strong>財政部青年首購低利貸款：</strong>提供優惠利率與較高貸款額度</li>
    <li><strong>各縣市首購補助：</strong>部分縣市政府提供購屋補助或利息補貼</li>
    <li><strong>銀行首購專案：</strong>銀行針對首購族提供較優惠的貸款條件</li>
</ul>
<p class="note">各項優惠方案的申請條件與名額有限，建議及早規劃並向本公司諮詢最新方案資訊。</p>
HTML,
            ],
        ];

        foreach ($items as $item) {
            $faq = Faq::updateOrCreate(
                ['order' => $item['order']],
                ['category' => $item['category'], 'is_active' => true]
            );

            $faq->translations()->updateOrCreate(
                ['locale' => 'zh-TW'],
                ['question' => $item['question'], 'answer' => $item['answer']]
            );
        }
    }
}
