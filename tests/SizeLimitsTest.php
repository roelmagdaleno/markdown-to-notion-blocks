<?php

declare(strict_types=1);

test('a paragraph returns empty string because has more than 1950 characters', function () {
    $markdown = <<<'MD'
    Artificial Intelligence (AI) has evolved from a theoretical concept to a tangible force that is reshaping numerous industries worldwide. AI refers to the development of systems that can perform tasks typically requiring human intelligence, such as decision-making, problem-solving, and pattern recognition. While AI has been around for decades, the explosion of data, advances in computational power, and improvements in machine learning algorithms have accelerated its adoption across various sectors. One of the key areas where AI is making a significant impact is healthcare. The healthcare industry has always been data-rich, but the ability to analyze that data effectively has been limited by human capacity. With AI, healthcare professionals can now process vast amounts of data at unprecedented speeds, leading to more accurate diagnoses and personalized treatment plans. AI-powered diagnostic tools, such as image recognition software, are now being used to detect diseases like cancer, often at earlier stages than traditional methods. In addition, AI is being employed in drug discovery, helping researchers identify potential drug candidates more efficiently, speeding up the process of bringing new treatments to market. Beyond healthcare, AI is transforming the financial industry. Banks and financial institutions are increasingly utilizing AI to enhance customer service, improve risk management, and detect fraudulent activities. AI-driven chatbots provide customers with immediate assistance, streamlining the service process and improving customer satisfaction. In terms of risk management, AI algorithms can analyze market trends and predict financial risks with higher accuracy than human analysts, helping institutions make more informed investment decisions. Moreover, AI has revolutionized the fight against financial crime by detecting anomalies in transaction patterns, flagging potential fraud in real-time. The retail industry is also benefiting greatly from the adoption of AI. E-commerce giants like Amazon and Alibaba have pioneered the use of AI in understanding consumer behavior, improving supply chain logistics, and optimizing pricing strategies. By analyzing customer preferences and shopping habits, AI algorithms can create personalized shopping experiences, recommending products that align with individual tastes. AI also powers dynamic pricing, adjusting prices based on demand, competition, and market conditions in real-time, ensuring that retailers stay competitive while maximizing profits. On the supply chain front, AI tools can predict demand fluctuations, optimizing inventory levels and reducing wastage. In the realm of manufacturing, AI is ushering in a new era of efficiency through automation and predictive maintenance. Industrial robots powered by AI can perform repetitive tasks with a level of precision that is difficult to achieve through manual labor. These robots are not only enhancing productivity but also improving worker safety by taking on hazardous tasks. Furthermore, AI-based predictive maintenance systems monitor the health of equipment, detecting issues before they lead to costly breakdowns. This not only reduces downtime but also extends the lifespan of machinery, saving manufacturers significant amounts in repair and replacement costs. AI's influence is also being felt in the education sector, where it is changing the way students learn and teachers teach. AI-powered tutoring systems can provide personalized learning experiences for students, adapting to their individual learning paces and styles. This helps address the varying needs of students, ensuring that no one is left behind. AI tools are also assisting teachers by automating administrative tasks like grading, freeing up more time for lesson planning and student interaction. Additionally, AI-driven analytics can provide educators with insights into student performance, helping them identify areas where students may need additional support. Another industry where AI is making waves is transportation. The development of autonomous vehicles, powered by AI, promises to revolutionize the way we move goods and people. Companies like Tesla, Waymo, and Uber are at the forefront of developing self-driving cars, which have the potential to reduce traffic accidents, decrease fuel consumption, and improve transportation efficiency. In the logistics sector, AI is optimizing route planning, reducing delivery times, and cutting costs. AI-powered drones and robots are also being explored for last-mile delivery solutions, particularly in areas where traditional transportation methods face challenges. Entertainment and media are not immune to the AI revolution. AI is increasingly being used to create personalized content recommendations, whether it's movies on Netflix or songs on Spotify. By analyzing user preferences and consumption patterns, AI can suggest content that aligns with individual tastes, keeping users engaged for longer periods. In addition, AI-generated content, such as music, artwork, and even articles, is becoming more prevalent. AI algorithms are being trained to compose music, design logos, and write news stories, showcasing the creative potential of machines. While the benefits of AI are vast, there are also challenges and ethical considerations that come with its widespread adoption. One of the primary concerns is job displacement. As AI systems take over tasks previously performed by humans, there is a fear that many jobs will become obsolete. This is particularly relevant in industries like manufacturing and retail, where automation is reducing the need for manual labor. However, proponents of AI argue that while some jobs may be lost, new opportunities will emerge, particularly in fields related to AI development, data science, and AI ethics. Another significant concern is the issue of bias in AI systems. AI algorithms are only as good as the data they are trained on. If the data is biased, the AI system can perpetuate and even amplify those biases, leading to unfair outcomes. For example, biased AI algorithms in hiring processes could disadvantage certain demographic groups, reinforcing existing inequalities. As AI continues to permeate various aspects of society, there is a growing need for transparency and accountability in how these systems are developed and deployed. In conclusion, AI is transforming industries at an unprecedented pace, offering countless benefits in terms of efficiency, cost savings, and innovation. From healthcare and finance to education and entertainment, the applications of AI are vast and varied. However, as we continue to embrace this powerful technology, it is crucial to address the ethical challenges and ensure that AI is used responsibly, with a focus on fairness and inclusivity. The future of AI holds immense potential, and how we navigate its development will shape the world for generations to come.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Artificial Intelligence (AI) has evolved from a theoretical concept to a tangible force that is reshaping numerous industries worldwide. AI refers to the development of systems that can perform tasks typically requiring human intelligence, such as decision-making, problem-solving, and pattern recognition. While AI has been around for decades, the explosion of data, advances in computational power, and improvements in machine learning algorithms have accelerated its adoption across various sectors. One of the key areas where AI is making a significant impact is healthcare. The healthcare industry has always been data-rich, but the ability to analyze that data effectively has been limited by human capacity. With AI, healthcare professionals can now process vast amounts of data at unprecedented speeds, leading to more accurate diagnoses and personalized treatment plans. AI-powered diagnostic tools, such as image recognition software, are now being used to detect diseases like cancer, often at earlier stages than traditional methods. In addition, AI is being employed in drug discovery, helping researchers identify potential drug candidates more efficiently, speeding up the process of bringing new treatments to market. Beyond healthcare, AI is transforming the financial industry. Banks and financial institutions are increasingly utilizing AI to enhance customer service, improve risk management, and detect fraudulent activities. AI-driven chatbots provide customers with immediate assistance, streamlining the service process and improving customer satisfaction. In terms of risk management, AI algorithms can analyze market trends and predict financial risks with higher accuracy than human analysts, helping institutions make more informed investment decisions. Moreover, AI has revolutionized the fight against financial crime by detecting anomalies in transaction patterns, flagging potential fraud in real-time. The retail indu',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => "stry is also benefiting greatly from the adoption of AI. E-commerce giants like Amazon and Alibaba have pioneered the use of AI in understanding consumer behavior, improving supply chain logistics, and optimizing pricing strategies. By analyzing customer preferences and shopping habits, AI algorithms can create personalized shopping experiences, recommending products that align with individual tastes. AI also powers dynamic pricing, adjusting prices based on demand, competition, and market conditions in real-time, ensuring that retailers stay competitive while maximizing profits. On the supply chain front, AI tools can predict demand fluctuations, optimizing inventory levels and reducing wastage. In the realm of manufacturing, AI is ushering in a new era of efficiency through automation and predictive maintenance. Industrial robots powered by AI can perform repetitive tasks with a level of precision that is difficult to achieve through manual labor. These robots are not only enhancing productivity but also improving worker safety by taking on hazardous tasks. Furthermore, AI-based predictive maintenance systems monitor the health of equipment, detecting issues before they lead to costly breakdowns. This not only reduces downtime but also extends the lifespan of machinery, saving manufacturers significant amounts in repair and replacement costs. AI's influence is also being felt in the education sector, where it is changing the way students learn and teachers teach. AI-powered tutoring systems can provide personalized learning experiences for students, adapting to their individual learning paces and styles. This helps address the varying needs of students, ensuring that no one is left behind. AI tools are also assisting teachers by automating administrative tasks like grading, freeing up more time for lesson planning and student interaction. Additionally, AI-driven analytics can provide educators with insights into st",
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => "udent performance, helping them identify areas where students may need additional support. Another industry where AI is making waves is transportation. The development of autonomous vehicles, powered by AI, promises to revolutionize the way we move goods and people. Companies like Tesla, Waymo, and Uber are at the forefront of developing self-driving cars, which have the potential to reduce traffic accidents, decrease fuel consumption, and improve transportation efficiency. In the logistics sector, AI is optimizing route planning, reducing delivery times, and cutting costs. AI-powered drones and robots are also being explored for last-mile delivery solutions, particularly in areas where traditional transportation methods face challenges. Entertainment and media are not immune to the AI revolution. AI is increasingly being used to create personalized content recommendations, whether it's movies on Netflix or songs on Spotify. By analyzing user preferences and consumption patterns, AI can suggest content that aligns with individual tastes, keeping users engaged for longer periods. In addition, AI-generated content, such as music, artwork, and even articles, is becoming more prevalent. AI algorithms are being trained to compose music, design logos, and write news stories, showcasing the creative potential of machines. While the benefits of AI are vast, there are also challenges and ethical considerations that come with its widespread adoption. One of the primary concerns is job displacement. As AI systems take over tasks previously performed by humans, there is a fear that many jobs will become obsolete. This is particularly relevant in industries like manufacturing and retail, where automation is reducing the need for manual labor. However, proponents of AI argue that while some jobs may be lost, new opportunities will emerge, particularly in fields related to AI development, data science, and AI ethics. Another signif",
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'icant concern is the issue of bias in AI systems. AI algorithms are only as good as the data they are trained on. If the data is biased, the AI system can perpetuate and even amplify those biases, leading to unfair outcomes. For example, biased AI algorithms in hiring processes could disadvantage certain demographic groups, reinforcing existing inequalities. As AI continues to permeate various aspects of society, there is a growing need for transparency and accountability in how these systems are developed and deployed. In conclusion, AI is transforming industries at an unprecedented pace, offering countless benefits in terms of efficiency, cost savings, and innovation. From healthcare and finance to education and entertainment, the applications of AI are vast and varied. However, as we continue to embrace this powerful technology, it is crucial to address the ethical challenges and ensure that AI is used responsibly, with a focus on fairness and inclusivity. The future of AI holds immense potential, and how we navigate its development will shape the world for generations to come.',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
            ],
            'color' => 'default',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a link returns null value because has more than 1950 characters', function () {
    $markdown = <<<'MD'
    [Click here](https://example.com/abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuv)
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Click here',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
            ],
            'color' => 'default',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});
